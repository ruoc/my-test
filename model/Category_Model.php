<?php
class Category_Model extends Model
{
    /**
     * @return array|false
     */
    public function getPosts()
    {
        $currentDate = date('Y-m-d H:i:s');
        $this->db
            ->join('user u','u.id = p.user_id', 'LEFT')
            ->join('file f','f.id = p.file_id', 'LEFT')
            ->join('category c', 'c.id = p.category_id', 'LEFT');
        if(!Session::get('is_admin')){
            $this->db->where('p.published', 1);
            $this->db->where('p.published_date', $currentDate, '<='   );
        }
        $result = $this->db->get('posts p', null, ['u.firstname', 'u.lastname','f.image','f.thumb','c.category_name', 'p.*']);

        if ($result) {
            return $result;
        }
        return false;
    }

    public function getPostById($id)
    {
        $this->db
            ->join('user u','u.id = p.user_id', 'LEFT')
            ->join('file f','f.id = p.file_id', 'LEFT')
            ->join('category c', 'c.id = p.category_id', 'LEFT')
            ->where('p.id', $id);
        $result = $this->db->getOne('posts p', ['u.firstname', 'u.lastname','f.image','f.thumb','c.category_name', 'p.*']);

        if ($result) {
            return $result;
        }
        return false;
    }

    public function getPostsByCategoryId($id, $search)
    {
        $this->db
            ->join('user u','u.id = p.user_id', 'LEFT')
            ->join('file f','f.id = p.file_id', 'LEFT')
            ->join('category c', 'c.id = p.category_id', 'LEFT')
            ->where('p.category_id', $id)
            ->where('p.header', "%{$search}%",'LIKE');
        if(!Session::get('is_admin')){
            $this->db->where('p.published', 1);
            $this->db->where('p.published_date', date('Y-m-d H:i:s'), '<='   );
        }
        $this->db->orderBy('p.published_date');
        $result = $this->db->get('posts p', null, ['u.firstname', 'u.lastname','f.image','f.thumb','c.category_name', 'p.*']);

        if ($result) {
            return $result;
        }
        return false;
    }

    public function parseContent($content) {
        $parser = new Parsedown();
        return $parser->text($content);
    }
}