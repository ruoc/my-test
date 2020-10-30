<?php

class Auth_Model extends Model
{

    public function registerUser($user)
    {
        $password = $user['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $user['password'] = $hash;
        $data = array(
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'email' => $user['email'],
            'password' => $user['password']
        );
        return $this->db->insert('user', $data);
    }

    public function loginUser($user)
    {

        //Get userEntry from DB
        $userEntry = $this->getUserFromEmail($user['email']);
        //Check if user exists (and early return if not)
        if (!$userEntry) return false;

        //Get password and hash
        $password = $user['password'];
        $hash = $userEntry['password'];

        //Remove hashed password from $userEntry
        unset($userEntry['password']);

        //Add users fullname to $userEntry
        $userEntry['fullname'] = $userEntry['firstname'] . ' ' . $userEntry['lastname'];
        //Verify password
        if (password_verify($password, $hash)) return $userEntry;

        //Otherwise return false
        return false;
    }

    public function getUserFromEmail($email)
    {
        $this->db->join('file f', 'f.id = u.file_id', 'LEFT');
        $this->db->join('user_permission up', 'up.id = u.permission_id', 'LEFT');
        $this->db->where('u.email', $email);
        return $this->db->getOne('user u', ['u.*', 'f.image', 'f.thumb', 'up.permission']);
    }

    public function recordLoginAttempt($email)
    {
        $data = array(
            'login_attempts' => $this->db->inc(),
            'email' => $email
        );
        $this->db->where('email', $email);
        return $this->db->update('user', $data);
    }

    public function resetLoginAttempts($email)
    {
        $data = array(
            'login_attempts' => 0,
            'email' => $email
        );
        $this->db->where('email', $email);
        return $this->db->update('user', $data);
    }

    public function checkLoginAttempts($email)
    {
        $this->db->where('email', $email);
        $result = $this->db->getOne('user');
        if ($result) {
            return $result['login_attempts'];
        }
        return false;
    }
}
