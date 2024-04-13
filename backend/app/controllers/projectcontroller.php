<?php
namespace Controllers;

use Exception;
use Models\ProjectStatus;
use Services\UserService;
use Services\ProjectService;
use Models\Project;

class ProjectController extends Controller
{
    private $projectService;
    private $userService;

    // initialize services
    function __construct()
    {
        $this->projectService = new ProjectService();
        $this->userService = new UserService();
    }

    private function authenticateToken()
    {
        $authHeader = $this->getBearerToken();
        if (!$authHeader) {
            $this->respondWithError(401, "Authorization header is missing.");
            return false;
        }

        $token = $this->userService->verifyToken($authHeader);
        if (!$token) {
            $this->respondWithError(401, "Invalid token.");
            return false;
        }

        return $token;
    }

    public function getAll()
    {
        try {
            $token = $this->authenticateToken();
            if (!$token) {
                return;
            }

            if (!$this->userService->isUserAdmin($token->data->id)) {
                $this->respondWithError(403, "You are not authorized to access this resource.");
                return;
            }

            $offset = NULL;
            $limit = NULL;

            if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
                $offset = $_GET["offset"];
            }
            if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
                $limit = $_GET["limit"];
            }

            $projects = $this->projectService->getAll($offset, $limit);

            $this->respond($projects);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function getOwn()
    {
        try {
            $token = $this->authenticateToken();
            if (!$token) {
                return;
            }

            $offset = NULL;
            $limit = NULL;

            if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
                $offset = $_GET["offset"];
            }
            if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
                $limit = $_GET["limit"];
            }

            $projects = $this->projectService->getAllFromUser($token->data->id, $offset, $limit);

            $this->respond($projects);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function getOne($id)
    {
        try {
            $token = $this->authenticateToken();
            if (!$token) {
                return;
            }

            $project = $this->projectService->getOne($id);

            // Error checking: return 404 if project not found
            if (!$project) {
                $this->respondWithError(404, "Project not found");
                return;
            }

            // Check if user is authorized to access this project
            // Admins can access any project, but regular users can only access their own projects
            if ($project->userid != $token->data->id && !$this->userService->isUserAdmin($token->data->id)) {
                $this->respondWithError(403, "You are not authorized to access this resource.");
                return;
            }

            $this->respond($project);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $token = $this->authenticateToken();
            if (!$token) {
                return;
            }

            $data = $this->getPostedJson();
            if (empty($data->userid) || empty($data->name)) {
                $this->respondWithError(400, "UserID and name are required.");
                return;
            }

            if ($data->userid != $token->data->id && !$this->userService->isUserAdmin($token->data->id)) {
                $this->respondWithError(403, "You are not authorized to access this resource.");
                return;
            }

            $project = $this->createProjectFromPostedJson($data);
            $project = $this->projectService->insert($project);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
            return;
        }

        $this->respond($project);
    }

    public function update($id)
    {
        try {
            $token = $this->authenticateToken();
            if (!$token) {
                return;
            }

            $data = $this->getPostedJson();
            if (empty($data->userid) || empty($data->name)) {
                $this->respondWithError(400, "UserID and name are required.");
                return;
            }

            if ($data->userid != $token->data->id && !$this->userService->isUserAdmin($token->data->id)) {
                $this->respondWithError(403, "You are not authorized to access this resource.");
                return;
            }

            $project = $this->createProjectFromPostedJson($data);
            $project = $this->projectService->update($project, $id);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
            return;
        }

        $this->respond($project);
    }

    public function delete($id)
    {
        try {
            $token = $this->authenticateToken();
            if (!$token) {
                return;
            }

            $project = $this->projectService->getOne($id);
            if (!$project) {
                $this->respondWithError(404, "Project not found");
                return;
            }

            if ($project->userid != $token->data->id && !$this->userService->isUserAdmin($token->data->id)) {
                $this->respondWithError(403, "You are not authorized to access this resource.");
                return;
            }

            $this->projectService->delete($id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
            return;
        }

        $this->respond(true);
    }

    /**
     * Creates a new Project object from the provided JSON data.
     *
     * @param object $data The JSON data containing the project details.
     * @return Project The newly created Project object.
     */
    public function createProjectFromPostedJson($data)
    {
        $project = new Project();

        // UserID validation
        if (empty($data->userid)) {
            throw new Exception("UserID is required.");
        }
        $project->userid = !empty($data->userid) ? htmlspecialchars($data->userid) : null;

        // Name validation
        if (empty($data->name)) {
            throw new Exception("Project name is required.");
        }

        if (!empty($data->name) && strlen($data->name) > 32) {
            throw new Exception("Project name must be 32 characters or less.");
        }
        $project->name = !empty($data->name) ? htmlspecialchars($data->name) : null;


        // Description validation
        if (!empty($data->description) && strlen($data->description) > 65535) {
            throw new Exception("Project description must be 65535 characters or less.");
        }
        $project->description = !empty($data->description) ? htmlspecialchars($data->description) : null;

        // Other fields with no validation
        $project->status = !empty($data->status) ? ProjectStatus::getFromString(htmlspecialchars($data->status)) : null;
        $project->creation_date = !empty($data->creation_date) ? htmlspecialchars($data->creation_date) : null;

        // Due date validation
        if (!empty($data->due_date) && !strtotime($data->due_date)) {
            throw new Exception("Invalid due date.");
        }
        $project->due_date = !empty($data->due_date) ? htmlspecialchars($data->due_date) : null;

        return $project;
    }
}
