<?php


class Home extends Controller
{


    # render all posts on the start page
    public function index()
    {
        $data = $this->model->getPosts();
        foreach ($data as &$post){
            $post['content'] = strip_tags($this->parseContent($post['content']));
        }
        $this->view->post = $data;
        $this->view->render('home/index');
    }

    protected function parseContent($content) {
        $parser = new Parsedown();
        return $parser->text($content);
    }
}