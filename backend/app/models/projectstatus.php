<?php
namespace Models;

enum ProjectStatus implements \JsonSerializable {
    case NOT_STARTED;
    case IN_PROGRESS;
    case FINISHED;

    public static function getFromString(string $status): ProjectStatus {
        switch ($status) {
            case "NOT_STARTED":
                return ProjectStatus::NOT_STARTED;
            case "IN_PROGRESS":
                return ProjectStatus::IN_PROGRESS;
            case "FINISHED":
                return ProjectStatus::FINISHED;
            default:
                throw new \InvalidArgumentException("Invalid project status: $status");
        }
    }

    public function jsonSerialize(): string {
        return $this->toString();
    }

    public function toString(): string {
        return match ($this) {
            ProjectStatus::NOT_STARTED => "NOT_STARTED",
            ProjectStatus::IN_PROGRESS => "IN_PROGRESS",
            ProjectStatus::FINISHED => "FINISHED",
        };
    }
}