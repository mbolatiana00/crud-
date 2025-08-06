<?php

namespace App\entity;

class NotificationEntity
{
    private int $id;
    private int $user_id;
    private string $message;
    private bool $is_read;
    private string $created_at;

    public function __construct(
        int $id,
        int $user_id,
        string $message,
        bool $is_read,
        string $created_at
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->message = $message;
        $this->is_read = $is_read;
        $this->created_at = $created_at;
    }

    
    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function isRead(): bool
    {
        return $this->is_read;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function setIsRead(bool $is_read): void
    {
        $this->is_read = $is_read;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }
}
