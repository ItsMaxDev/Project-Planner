<?php
namespace Models;

class Project {
    public ?int $id;
    public ?int $userid;
    public ?string $name;
    public ?string $description;
    public ?ProjectStatus $status;
    public ?string $creation_date;
    public ?string $due_date;
}