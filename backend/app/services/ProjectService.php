<?php
namespace Services;

use Repositories\ProjectRepository;

class ProjectService
{
    private $repository;

    function __construct()
    {
        $this->repository = new ProjectRepository();
    }

    public function getAll($offset = NULL, $limit = NULL)
    {
        return $this->repository->getAll($offset, $limit);
    }

    public function getAllFromUser($userid, $offset = NULL, $limit = NULL)
    {
        return $this->repository->getAllByUser($userid, $offset, $limit);
    }

    public function getOne($id)
    {
        return $this->repository->getOne($id);
    }

    public function insert($project)
    {
        return $this->repository->insert($project);
    }

    public function update($project, $id)
    {
        return $this->repository->update($project, $id);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
