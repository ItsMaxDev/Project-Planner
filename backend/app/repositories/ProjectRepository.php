<?php

namespace Repositories;

use PDO;
use PDOException;
use Repositories\Repository;

use Models\Project;
use Models\ProjectStatus;

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

    function getAllByUser($userid, $offset = NULL, $limit = NULL)
    {
        try {
            $query = "SELECT * FROM projects WHERE userid = :userid";
            if (isset($limit) && isset($offset)) {
                $query .= " LIMIT :limit OFFSET :offset";
            }
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':userid', $userid);
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
        if (!$row) {
            return null;
        }

        $project = new Project();
        $project->id = $row['id'];
        $project->userid = $row['userid'];
        $project->name = $row['name'];
        $project->description = $row['description'];
        $project->status = ProjectStatus::getFromString($row['status']);
        $project->creation_date = $row['creation_date'];
        $project->due_date = $row['due_date'];
    
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

            $stmt->execute([$project->userid, $project->name, $project->description, $project->status->toString(), $project->creation_date, $project->due_date, $id]);

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
