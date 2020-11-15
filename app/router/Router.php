<?php

namespace App\router;

use ReflectionClass;

/**
 * Class Router
 * @package App\router
 */
class Router
{
    /**
     * @var string
     */
    private string $uri;
    /**
     * @var array|string[]
     */
    private array $controllers = ["Home", "Admin", "Posts", "Users"];
    /**
     * @var string
     */
    private string $explicitController;
    /**
     * @var string
     */
    private string $explicitMethod;
    /**
     * @var array
     */
    private array $explicitParams;
    /**
     * @var array|null
     */
    private ?array $callable = [];

    /**
     * Router constructor.
     *
     * @param string $uri
     *
     * @throws \App\router\RouterException
     * @throws \ReflectionException
     */
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

    /**
     *
     * @throws \ReflectionException
     */
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

    /**
     * @param string $controller
     * @param        $uriParams
     *
     * @return bool
     * @throws \ReflectionException
     */
    private function containRealMethod(string $controller, array $uriParams): bool
    {
        return (count($uriParams) == 1 and $this->hasMethod($controller, $uriParams[0])) or count($uriParams) > 1;
    }

    /**
     * @param string $controller
     * @param string $methodName
     *
     * @return bool
     * @throws \ReflectionException
     */
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

    /**
     * @param array|null $params
     */
    private function addingPostParams(?array &$params): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_FILES as $key => $image) {
                if (
                    $_FILES[$key]['error'] == 0
                    and ($_FILES[$key]['size'] <= 1000000)
                ) {
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

    /**
     * @return array|null
     * @throws \App\router\RouterException
     */
    private function getMethod(): ?array
    {
        // chaque url est contruite comme ceci : http://domain/controller/params...
        // on recupère le contrôleur et les paramètres
        $split = explode("/", $this->uri);
        if ($split[0] === "/") {
            array_shift($split);
        }
        if (!in_array(ucfirst($split[0]), $this->controllers)) {
            throw new RouterException("Pas de route pour l'url saisie");
        }
        return $this->getMatchMethod($split);
    }

    /**
     * @param array $splitUri
     *
     * @return array
     * @throws \App\router\RouterException
     */
    private function getMatchMethod(array $splitUri): array
    {
        // recherche des méthodes compatibles pour le contrôleur on utilise la rélfexion
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

    /**
     * @param array $methodParameters
     * @param array $uriParameters
     *
     * @return bool
     */
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

    /**
     * @param string $type1
     * @param string $type2
     *
     * @return bool
     */
    private function compareTypes(string $type1, string $type2): bool
    {
        return $type1 == $type2;
    }

    /**
     * @param $param
     *
     * @return string
     */
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

    /**
     * @return object|null
     */
    public function run(): ?object
    {
        $controller = new $this->callable[0]();
        return call_user_func_array([$controller, $this->callable[1]], $this->callable[2]);
    }
}
