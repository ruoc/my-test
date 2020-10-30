<?php


class Home_Model extends Model
{

    public function getPosts()
    {
        $this->db->join('user u', 'u.id = p.user_id', 'LEFT');
        $this->db->join('file f', 'f.id = p.file_id', 'LEFT');
        $this->db->join('category c', 'c.id = p.category_id', 'LEFT');
        if(!Session::get('is_admin')){
            $this->db->where('p.published', 1);
            $this->db->where('p.published_date', date('Y-m-d H:i:s'), '<='   );
        }
        $this->db->orderBy('p.published_date');
        $results = $this->db->get('posts p', null, ['p.*','f.image','f.thumb','c.category_name','u.firstname','u.lastname']);
        if ($results) {
            return $results;
        }

        return false;
    }

    public function getPostsTotal()
    {
        return $this->db->getValue('posts', "count(*)");
    }

    public function paginationCount($limit, $offset)
    {
        $result = $this->db->withTotalCount()->get('posts', array($offset, $limit));
        // Do we have any results?
        if ($result) {
            // Display the results
            foreach ($result as $row) {
                echo '<p>', $row['name'], '</p>';
            }
        }
    }

}