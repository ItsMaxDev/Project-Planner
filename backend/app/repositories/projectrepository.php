<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;

use Models\Project;

class ProjectRepository extends Repository
{
    function getAll($offset = NULL, $limit = NULL)
    {
        try {
            $query = "SELECT * FROM projects";
            if (isset($limit) && isset($offset)) {
                $query .= " LIMIT :limit OFFSET :offset";
            }
            $stmt = $this->connection->prepare($query);
            if (isset($limit) && isset($offset)) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            }
            $stmt->execute();

            $projects = array();
            while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
                $projects[] = $this->rowToProject($row);
            }

            return $projects;
        } catch (PDOException $e) {
            echo $e;
        }
    }


    function getOne($id)
    {
        try {
            $query = "SELECT * FROM projects WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            $project = $this->rowToProject($row);

            return $project;
        } catch (PDOException $e) {
            echo $e;
        }
    }


    function rowToProject($row) {
        $project = new Project();
        $project->id = $row['id'];
        $project->userid = $row['userid'];
        $project->name = $row['name'];
        $project->description = $row['description'];
        $project->status = ProjectStatus::$row['status']();
        $project->creation_date = new \DateTime($row['creation_date']);
        $project->due_date = isset($row['due_date']) ? new \DateTime($row['due_date']) : null;
    
        return $project;
    }    

    function insert($project)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO projects (userid, name, description, due_date) VALUES (?, ?, ?, ?)");

            $stmt->execute([$project->userid, $project->name, $project->description, $project->due_date]);

            $project->id = $this->connection->lastInsertId();

            return $this->getOne($project->id);
        } catch (PDOException $e) {
            echo $e;
        }
    }



    
    function update($project, $id)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE projects SET userid = ?, name = ?, description = ?, status = ?, creation_date = ?, due_date = ? WHERE id = ?");

            $stmt->execute([$project->userid, $project->name, $project->description, $project->status, $project->creation_date->format('Y-m-d H:i:s'), $project->due_date ? $project->due_date->format('Y-m-d H:i:s') : null, $id]);

            return $this->getOne($id);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function delete($id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM projects WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return;
        } catch (PDOException $e) {
            echo $e;
        }
        return true;
    }
}
