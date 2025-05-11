<?php
class UserController extends BaseController
{
    public function listAction()
    {
        $erroDescription = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $stringParamnsArray = $this->getStringParams();

        if(strtoupper($requestMethod) == 'GET'){
            try{
                $userModel = new UserModel();

                $intLimit = 10;
                if(isset($stringParamnsArray['limit']) && $stringParamnsArray['limit']){
                    $intLimit = $stringParamnsArray['limit'];
                }

                $usersArray = $userModel-> getUsers($intLimit);
                $responseData = json_encode($usersArray);
            } catch (Error $e){
                $erroDescription = $e->getMessage().'something whent wrong! please contact support';
                $errorHeader = 'HTTP/1.1 500 Internal Server Error';

            }
        }else{
            $erroDescription = 'Method not supported';
            $errorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        
    

    //send output
    if(!$erroDescription){
        $this->sendOutput(
            $responseData,
            array('Content-Type: aplication/json', 'HTTP/1.1 200 OK')    
        );
    }else{
        $this->sendOutput(json_encode(array('error' => $erroDescription)),
            array('content-Type: application/json', $errorHeader)
    );
    }
}
}
?>