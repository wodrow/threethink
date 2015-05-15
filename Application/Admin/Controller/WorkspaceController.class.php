<?php
namespace Admin\Controller;
class WorkSpaceController extends MemberController {

public function _initialize()
    {
        parent::_initialize();
        C('WEB_TITLE','三思框架-工作空间');
    }

    public function index()
    {
        // header("Location: /".U(CONTROLLER_NAME."/test2"));
        $this->
display("Base:data_index");
    }

    public function test()
    {
        C('WEB_TITLE','三思框架-test');
        $this->data_display('Test');
    }

    public function uploadify()
    {
        /*
        Uploadify
        Copyright (c) 2012 Reactive Apps, Ronnie Garcia
        Released under the MIT License
<http://www.opensource.org/licenses/mit-license.php>
    */
        // Define a destination
        // $targetFolder = '/uploads'; // Relative to the root
        if (I('get.model_name')) {
            $model_name = I("get.model_name");
        }else{
            $this->error("no upload model directory define");
        }

        $verifyToken = md5('unique_salt' . $_POST['timestamp']);

        if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
            $tempFile = $_FILES['Filedata']['tmp_name'];
            // $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            // $targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
            $targetFile= './Uploads/images/'.$model_name.'/'.$_FILES['Filedata']['name'];
            // file_put_contents("filename", $targetFile);
            
            // Validate the file type
            $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            
            if (in_array($fileParts['extension'],$fileTypes)) {
                move_uploaded_file($tempFile,$targetFile);
                echo '1';
            } else {
                echo 'Invalid file type.';
            }
        }
    }
}