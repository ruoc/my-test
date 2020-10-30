<?php

class Dashboard_Model extends Model
{
    public function addPost($category_id, $userId, $post_header, $post_content, $uploadedFile)
    {

        // 1. Step: insert File ----------------------------------------------------------------------------------------------
        $data = array(
            'name' => $uploadedFile['name'],
            'image' => $uploadedFile['image'],
            'thumb' => $uploadedFile['thumb'],
            'size' => $uploadedFile['size'],
        );
        $step1 = $this->db->insert('file', $data);
        // Remember the id of the new file entry
        $file_id = $this->db->getInsertId();


        // 2. Step: insert Post ----------------------------------------------------------------------------------------------
        $data = array(
            "header" => $post_header,
            "content" => $post_content,
            "user_id" => $userId,
            "file_id" => $file_id,
            "category_id" => $category_id,
        );
        $step2 = $this->db->insert('posts', $data);
        
        return $step1 && $step2;
    }

    public function uploadUserImage($userId, $uploadedFile)
    {
        // 1. Step: insert File ----------------------------------------------------------------------------------------------
        $data = array(
            'name' => $uploadedFile['name'],
            'image' => $uploadedFile['image'],
            'thumb' => $uploadedFile['thumb'],
            'size' => $uploadedFile['size'],
        );
        $step1 = $this->db->insert('file', $data);
        // Remember the id of the new file entry
        $file_id = $this->db->getInsertId();

        // 2. Step: insert Post ----------------------------------------------------------------------------------------------
        $data = array(
            "id" => $userId,
            "file_id" => $file_id,
        );
        $step2 = $this->db->update('user', $data);
        return $step1 && $step2;
    }
    public function createFile($file){
        $this->db->insert('file', $file);
        return $this->db->getInsertId();
    }
    public function updateFile($file_id, $file)
    {
        $data = array(
            'name' => $file['name'],
            'image' => $file['image'],
            'thumb' => $file['thumb'],
            'size' => $file['size'],
        );
        $this->db->where('id', $file_id);
        $result = $this->db->update('file', $data);
        // Return result
        return $result;
    }

    public function editProfile($user_id, $post_firstname, $post_lastname, $post_email, $post_password)
    {
        $data = array(
            "firstname" => $post_firstname,
            "lastname" => $post_lastname,
            "email" => $post_email,
            "id" => $user_id
        );
        if (!empty($post_password)) {
            $password = $post_password;
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $post_password = $hashPassword;
            $data['password'] = $post_password;
        }
        return $this->db->update('user', $data);
    }

    public function getPosts()
    {
        $this->db->join('user u', 'u.id = p.user_id', 'LEFT');
        $this->db->join('file f', 'f.id = p.file_id', 'LEFT');
        $this->db->join('category c', 'c.id = p.category_id', 'LEFT');
        $this->db->orderBy('timestamp');
        return $this->db->get('posts p', null, ['u.firstname', 'u.lastname','f.image','f.thumb','c.category_name','p.*']);
    }

    public function getPostById($id)
    {
        $this->db->join('user u', 'u.id = p.user_id', 'LEFT');
        $this->db->join('file f', 'f.id = p.file_id','LEFT');
        $this->db->join('category c', 'c.id = p.category_id', 'LEFT');
        $this->db->where('p.id', $id);
        $this->db->orderBy('timestamp');
        return $this->db->getOne('posts p', ['u.firstname', 'u.lastname','f.image','f.thumb','c.category_name','p.*']);
    }

    public function getFileById($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('file');
    }

    public function getPostsByEmail()
    {
        $this->db->join('user u', 'u.id = p.user_id', 'LEFT');
        $this->db->join('file f', 'f.id = p.file_id', 'LEFT');
        $this->db->join('category c', 'c.id = p.category_id', 'LEFT');
        $this->db->where('u.email', Session::get('user')['email']);
        return $this->db->get('posts p', null, ['u.firstname', 'u.lastname','f.image','f.thumb','c.category_name','p.*']);
    }

    public function getUserById($id)
    {
        $this->db->join('file f', 'f.id = u.file_id', 'LEFT');
        $this->db->join('user_permission up', 'up.id = u.permission_id', 'LEFT');
        $this->db->where('u.id', $id);
        return $this->db->getOne('user u', ['u.*', 'f.image', 'f.thumb', 'up.permission']);
    }

    public function getUserFromEmail($email)
    {
        $this->db->join('file f', 'f.id = u.file_id', 'LEFT');
        $this->db->join('user_permission up', 'up.id = u.permission_id', 'LEFT');
        $this->db->where('u.email', $email);
        return $this->db->getOne('user u', ['u.*', 'f.image', 'f.thumb', 'up.permission']);
    }

    public function updatePost($data)
    {
        $this->db->where('id', $data['id']);
        unset($data['id']);
        return $this->db->update('posts', $data);
    }

    public function getCategories()
    {
        return $this->db->get('category');
    }

    public function insertCategory($categoryName)
    {
        
        $data = array(
            "category_name" => $categoryName
        );
        return $this->db->insert('category', $data);
    }

    public function deleteCategory($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('category');    
    }
    
    public function getAllUsers()
    {
        $this->db->join('user_permission up', 'up.id = u.permission_id');
        $this->db->orderBy('u.email', 'ASC');
        return $this->db->get('user u', null, ['u.*', 'up.permission']);
    }

    public function updatePermission($permission, $userEmail)
    {
        $data = array(
            "permission" => $permission,
            "email" => $userEmail
        );
        return $this->db->update('user', $data);
    }

    public function getAllPermissions()
    {
        return $this->db->get('user_permission');
    }

    # ********************
    # Ban/Unban Functions
    # ********************

    public function unbanUser($userEmail)
    {
        $data = array(
            "login_attempts" => 0,
            "email" => $userEmail
        );
        return $this->db->update('user', $data);
    }

    public function banUser($userEmail)
    {
        $data = array(
            "login_attempts" => 3,
            "email" => $userEmail
        );
        return $this->db->update('user', $data);
    }

    # *****************
    # Delete Functions
    # *****************

    public function deleteFile($file_id)
    {
        $this->db->where('id', $file_id);
        return $this->db->delete('file');
    }

    public function deletePost($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('posts');
    }

}