<?php


namespace App\core\entity;


use App\core\database\DataAccessManager;

class FooterEntity extends DataAccessManager
{
    protected static $table = 'footer';
    protected static $_instance;

    protected function __construct() {
        parent::__construct();
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new FooterEntity();
        }
        return self::$_instance;
    }

    public function persoFooter ($footerModel) {
        $statement =
            "UPDATE `footer` SET `firstname`=?, `lastname`=?, `address`=?, `phoneNumber`=?, `email`=?, `facebookLink`=?,
                  `twitterLink`=?, `instagramLink`=?, `linkedinLink`=?, `githubLink`=?";
        $values=[];
        array_push($values, htmlspecialchars($footerModel->getFirstname()));
        array_push($values, htmlspecialchars($footerModel->getLastname()));
        array_push($values, htmlspecialchars($footerModel->getAddress()));
        array_push($values, htmlspecialchars($footerModel->getPhoneNumber()));
        array_push($values, htmlspecialchars($footerModel->getEmail()));
        array_push($values, htmlspecialchars($footerModel->getFacebookLink()));
        array_push($values, htmlspecialchars($footerModel->getTwitterLink()));
        array_push($values, htmlspecialchars($footerModel->getInstagramLink()));
        array_push($values, htmlspecialchars($footerModel->getLinkedinLink()));
        array_push($values, htmlspecialchars($footerModel->getGithubLink()));
        $insert = $this->pdo->prepare($statement);
        $insert->execute($values);
    }
}