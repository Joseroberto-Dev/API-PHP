<?

require_once ROOT_PATH. "/Model/Database.php";

class UserModel extends database
{
    public function getUsers(int $limit) : array
    {
        return $this->select($limit);
    }
}

?>