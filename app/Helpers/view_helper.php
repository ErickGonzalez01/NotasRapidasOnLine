<?php
function RenderView(string $view,array $data = [],array $options = []):string{
    return view('layout/header').view($view,$data,$options).view("layout/footer");
}
function RenderViewNav(string $view,array $data = [],array $options = []):string{
    return view('layout/header').view("layout/nav-bar").view($view,$data,$options).view("layout/footer");
}