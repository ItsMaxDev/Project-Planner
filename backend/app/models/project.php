<?php
namespace Models;

class Project {
    public int $id;
    public int $userid;
    public string $name;
    public string $description;
    public ProjectStatus $status;
    public \DateTime $creation_date;
    public ?\DateTime $due_date;
}
