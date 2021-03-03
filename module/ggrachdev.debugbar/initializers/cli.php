<?
// Укажите ваш DOCUMENT_ROOT
$_SERVER['DOCUMENT_ROOT'] = '/home/c/cq01452/public_html';

if (!empty($_SERVER['DOCUMENT_ROOT'])) {
    
    $_SERVER['DOCUMENT_ROOT'] = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
    
    include 'server.php';
}