<?php

declare(strict_types=1);

namespace App\Controllers;

/**
 * User Controller
 * Handles user-related endpoints
 */
class UserController
{
    /**
     * Sample users data
     */
    private static array $users = [
        ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'created_at' => '2025-07-21T12:00:00Z'],
        ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'created_at' => '2025-07-21T12:15:00Z'],
        ['id' => 3, 'name' => 'Bob Johnson', 'email' => 'bob@example.com', 'created_at' => '2025-07-21T12:30:00Z'],
    ];

    /**
     * Get all users
     * 
     * @param mixed $req Request object
     * @param mixed $res Response object
     * @return mixed JSON response
     */
    public function index($req, $res)
    {
        return $res->json([
            'users' => self::$users,
            'total' => count(self::$users),
            'timestamp' => date('c')
        ]);
    }

    /**
     * Get user by ID
     * 
     * @param mixed $req Request object
     * @param mixed $res Response object
     * @return mixed JSON response
     */
    public function show($req, $res)
    {
        $id = (int) $req->param('id');
        
        $user = collect(self::$users)->firstWhere('id', $id);
        
        if (!$user) {
            return $res->status(404)->json([
                'error' => 'User not found',
                'message' => "User with ID {$id} does not exist",
                'timestamp' => date('c')
            ]);
        }

        return $res->json([
            'user' => $user,
            'timestamp' => date('c')
        ]);
    }

    /**
     * Create new user
     * 
     * @param mixed $req Request object
     * @param mixed $res Response object
     * @return mixed JSON response
     */
    public function store($req, $res)
    {
        $data = $req->body();
        
        // Simple validation
        if (!isset($data['name']) || !isset($data['email'])) {
            return $res->status(400)->json([
                'error' => 'Validation failed',
                'message' => 'Name and email are required',
                'timestamp' => date('c')
            ]);
        }

        // Create new user
        $newUser = [
            'id' => count(self::$users) + 1,
            'name' => $data['name'],
            'email' => $data['email'],
            'created_at' => date('c')
        ];

        self::$users[] = $newUser;

        return $res->status(201)->json([
            'message' => 'User created successfully',
            'user' => $newUser,
            'timestamp' => date('c')
        ]);
    }

    /**
     * Update user
     * 
     * @param mixed $req Request object
     * @param mixed $res Response object
     * @return mixed JSON response
     */
    public function update($req, $res)
    {
        $id = (int) $req->param('id');
        $data = $req->body();
        
        $userIndex = null;
        foreach (self::$users as $index => $user) {
            if ($user['id'] === $id) {
                $userIndex = $index;
                break;
            }
        }
        
        if ($userIndex === null) {
            return $res->status(404)->json([
                'error' => 'User not found',
                'message' => "User with ID {$id} does not exist",
                'timestamp' => date('c')
            ]);
        }

        // Update user data
        if (isset($data['name'])) {
            self::$users[$userIndex]['name'] = $data['name'];
        }
        if (isset($data['email'])) {
            self::$users[$userIndex]['email'] = $data['email'];
        }
        self::$users[$userIndex]['updated_at'] = date('c');

        return $res->json([
            'message' => 'User updated successfully',
            'user' => self::$users[$userIndex],
            'timestamp' => date('c')
        ]);
    }

    /**
     * Delete user
     * 
     * @param mixed $req Request object
     * @param mixed $res Response object
     * @return mixed JSON response
     */
    public function destroy($req, $res)
    {
        $id = (int) $req->param('id');
        
        $userIndex = null;
        foreach (self::$users as $index => $user) {
            if ($user['id'] === $id) {
                $userIndex = $index;
                break;
            }
        }
        
        if ($userIndex === null) {
            return $res->status(404)->json([
                'error' => 'User not found',
                'message' => "User with ID {$id} does not exist",
                'timestamp' => date('c')
            ]);
        }

        // Remove user
        $deletedUser = self::$users[$userIndex];
        array_splice(self::$users, $userIndex, 1);

        return $res->status(204)->json([
            'message' => 'User deleted successfully',
            'deleted_user' => $deletedUser,
            'timestamp' => date('c')
        ]);
    }
}

/**
 * Helper function to simulate Laravel's collect()
 */
function collect(array $items): object 
{
    return new class($items) {
        private array $items;
        
        public function __construct(array $items) {
            $this->items = $items;
        }
        
        public function firstWhere(string $key, mixed $value): ?array {
            foreach ($this->items as $item) {
                if (isset($item[$key]) && $item[$key] === $value) {
                    return $item;
                }
            }
            return null;
        }
    };
}