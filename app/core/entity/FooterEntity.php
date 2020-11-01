<?php


namespace App\core\entity;


use App\core\database\DataAccessManager;

class FooterEntity extends DataAccessManager
{
    protected static $table = 'footer';
    protected static $_instance;

    protected function __construct()
    {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new FooterEntity();
        }
        return self::$_instance;
    }

    public function persoFooter($footerModel)
    {
        $statement =
            "UPDATE `footer` SET `firstname`=?, `lastname`=?, `address`=?, `phoneNumber`=?, `email`=?, `facebookLink`=?,
                  `twitterLink`=?, `instagramLink`=?, `linkedinLink`=?, `githubLink`=?";
        $values = [$footerModel->getFirstname(),
            $footerModel->getLastname(),
            $footerModel->getAddress(),
            $footerModel->getPhoneNumber(),
            $footerModel->getEmail(),
            $footerModel->getFacebookLink(),
            $footerModel->getTwitterLink(),
            $footerModel->getInstagramLink(),
            $footerModel->getLinkedinLink(),
            $footerModel->getGithubLink()];
        $insert = $this->pdo->prepare($statement);
        $insert->execute($values);
    }
}