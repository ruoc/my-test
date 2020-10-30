<?php

class Category extends Controller
{
    /**
     * Show category action
     * @param $id
     */
    public function showCategory($id)
    {
        Session::set('activeCategory', $id);
        $categories = Session::get('categories');
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $result = $this->model->getPostsByCategoryId($id, $search);
        if($result){
            $this->view->posts = $result;
            foreach ($this->view->posts as &$post){
                $post['content'] = strip_tags($this->model->parseContent($post['content']));
            }
        }
        $this->view->render('category/showAll');
    }

    # ************************
    # Show Post Functionality
    # ************************

    public function show($id)
    {
        # Get all Data needed for post
        $data = $this->model->getPostById($id);
        $data['content'] = $this->model->parseContent($data['content']);
        # Passing it into the view
        $this->view->data = $data;

        $this->view->render('category/show');
    }

    # ************************
    # Standard Index Render
    # ************************

    public function index()
    {
        $this->view->render('category/digitalminimalism');
    }

}