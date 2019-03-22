<?php
/**
 * Petstore App Singleton
 */

namespace Petstore;


class App
{

    /**
     * @var \mysqli
     */
    public $db;

    /**
     * @var \Bullet\App
     */
    public $api;

    /**
     * @var App
     */
    private static $instance;

    /**
     * @var string
     */
    private $dbHost = 'db';

    /**
     * @var string
     */
    private $dbUser = 'petstore';

    /**
     * @var string
     */
    private $dbPass = 'petstore';

    /**
     * @var string
     */
    private $dbName = 'petstore';


    /**
     * App constructor.
     *
     * @throws \Exception
     */
    private function __construct()
    {
        $this->db = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);

        if (!$this->db) {
            throw new \Exception('Unable to connect to MySQL: ' . mysqli_connect_errno() . ' - ' . mysqli_connect_error());
        }
    }


    /**
     * @return App
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new App();
        }

        return self::$instance;
    }


    /**
     * Api Setup and Entry
     */
    public function run()
    {
        // Rest Server App
        $api     = new \Bullet\App();
        $request = new \Bullet\Request();

        // Display exceptions with error and 500 status
        $api->on('Exception', function (\Bullet\Request $request, \Bullet\Response $response, \Exception $e) use ($api) {
            if ($request->format() === 'json') {
                $response->content([
                    'error'   => get_class($e),
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage(),
                    //'trace'   => debug_backtrace(),
                ]);
            } else {
                print 'Error: ' . $e->getMessage() . "\r\n";
            }
        });

        // API Routes
        require BACKEND . '/Routes/index.php';
        require BACKEND . '/Routes/user.php';
        require BACKEND . '/Routes/pet.php';

        $this->api = $api;

        // Process the request
        print $this->api->run($request);
    }


    /**
     * Destructor
     */
    public function __destruct()
    {
        mysqli_close($this->db);
    }
}
