<?php

namespace App\router;

use ReflectionClass;


class Router
{
    private string $uri;
    private array $controllers = ["Home", "Admin", "Posts", "Users"];
    private string $explicitController;
    private string $explicitMethod;
    private array $explicitParams;
    private ?array $callable = [];

    public function __construct(string $uri)
    {
        $this->uri = $uri;
        $this->findExplicitMethod();
        if (isset($this->explicitMethod)) {
            $this->addingPostParams($this->explicitParams);
            $this->callable = [$this->explicitController, $this->explicitMethod, $this->explicitParams];
            return;
        }
        $this->callable = $this->getMethod();
    }

    private function findExplicitMethod(): void
    {
        $split = explode("/", $this->uri);
        $controller = $split[0];
        array_shift($split);
        foreach ($split as $uriContent) {
            $uriParams = explode(":", $uriContent);
            if ($this->containRealMethod($controller, $uriParams)) {
                $this->explicitController = "App\\Controller\\" . ucfirst($controller) . "Controller";
                $this->explicitMethod = $uriParams[0];
                array_shift($uriParams);
                $this->explicitParams = is_array($uriParams) ? $uriParams : [$uriParams];
            }
        }
    }

    private function containRealMethod(string $controller, array $uriParams): bool
    {
        return (count($uriParams) == 1 and $this->hasMethod($controller, $uriParams[0])) or count($uriParams) > 1;
    }

    private function hasMethod(string $controller, string $methodName): bool
    {
        if (!in_array(ucfirst($controller), $this->controllers)) {
            return false;
        }
        $reflector = new ReflectionClass("App\\Controller\\" . $controller . "Controller");
        $methods = $reflector->getMethods();
        foreach ($methods as $method) {
            if ($method->getName() == $methodName) {
                return true;
            }
        }
        return false;
    }

    private function addingPostParams(?array &$params): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_FILES as $key => $image) {
                if ($_FILES[$key]['error'] == 0 and ($_FILES[$key]['size'] <= 1000000)) {
                    $infoFileUploaded = pathinfo($_FILES[$key]['name']);
                    $extensionFileUploaded = $infoFileUploaded['extension'];
                    $authorizedExtensions = array('jpg', 'jpeg', 'gif', 'png');
                    if (in_array($extensionFileUploaded, $authorizedExtensions)) {
                        move_uploaded_file($_FILES[$key]['tmp_name'], './img/' . basename($_FILES[$key]['name']));
                    }
                    $_POST[$key] = $_FILES[$key]['name'];
                }
            }
            $params = !isset($params) ? [] : $params;
            array_push($params, $_POST);
        }
    }

    private function getMethod(): ?array
    {
        $split = explode("/", $this->uri);
        if ($split[0] === "/") {
            array_shift($split);
        }
        if (!in_array(ucfirst($split[0]), $this->controllers)) {
            throw new RouterException("Pas de route pour l'url saisie");
        }
        return $this->getMatchMethod($split);
    }

    private function getMatchMethod(array $splitUri): array
    {
        $controller = "App\\Controller\\" . ucfirst($splitUri[0]) . "Controller";
        array_shift($splitUri);
        $this->addingPostParams($splitUri);
        try {
            $reflector = new ReflectionClass($controller);
            $methods = $reflector->getMethods();
            foreach ($methods as $method) {
                if ($method->isPublic() and !$method->isConstructor()) {
                    $params = $method->getParameters();
                    if ($this->compareParameters($params, $splitUri)) {
                        return [$controller, $method->getName(), $splitUri];
                    }
                }
            }
            throw new RouterException("Pas de route pour l'url saisie");
        } catch (\ReflectionException $e) {
            throw new RouterException("Pas de route pour l'url saisie");
        }
    }

    private function compareParameters(array $methodParameters, array $uriParameters): bool
    {
        if (count($methodParameters) == 0 and count($uriParameters) == 0) {
            return true;
        }
        if (count($methodParameters) !== count($uriParameters)) {
            return false;
        }
        for ($i = 0; $i < count($methodParameters); $i++) {
            if (!$this->compareTypes($methodParameters[$i]->getType(), $this->convertParam($uriParameters[$i]))) {
                return false;
            }
        }
        return true;
    }

    private function compareTypes(string $type1, string $type2): bool
    {
        return $type1 == $type2;
    }

    private function convertParam($param): string
    {
        if (is_array($param)) {
            return "array";
        }
        if (intval($param)) {
            return "int";
        }
        return "string";
    }

    public function run(): ?object
    {
        $controller = new $this->callable[0]();
        return call_user_func_array([$controller, $this->callable[1]], $this->callable[2]);
    }
}
