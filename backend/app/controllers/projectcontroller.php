<?php
namespace Controllers;

use Exception;
use Services\ProjectService;

class ProjectController extends Controller
{
    private $service;

    // initialize services
    function __construct()
    {
        $this->service = new ProjectService();
    }

    public function getAll()
    {
        $offset = NULL;
        $limit = NULL;

        if (isset($_GET["offset"]) && is_numeric($_GET["offset"])) {
            $offset = $_GET["offset"];
        }
        if (isset($_GET["limit"]) && is_numeric($_GET["limit"])) {
            $limit = $_GET["limit"];
        }

        $projects = $this->service->getAll($offset, $limit);

        $this->respond($projects);
    }

    public function getOne($id)
    {
        $project = $this->service->getOne($id);

        // Error checking: return 404 if project not found
        if (!$project) {
            $this->respondWithError(404, "Project not found");
            return;
        }

        $this->respond($project);
    }

    public function create()
    {
        try {
            $project = $this->createObjectFromPostedJson("Models\\Project");
            $project = $this->service->insert($project);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
            return;
        }

        $this->respond($project);
    }

    public function update($id)
    {
        try {
            $project = $this->createObjectFromPostedJson("Models\\Project");
            $project = $this->service->update($project, $id);

        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
            return;
        }

        $this->respond($project);
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
        } catch (Exception $e) {
            $this->respondWithError(500, $e->getMessage());
            return;
        }

        $this->respond(true);
    }
}
