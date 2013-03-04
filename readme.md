I tried to make this framework as simple as possible.

Once you down load it you can throw all of the files away except index.php and application.php.

The .htaccess sends everything to index.php and index.php loads the application.php file which in turn loads the correct controller and method.

The most basic controller is

	class mainController {
		public function indexAction() {
			echo('You have reached the Main Controller Index Action');
		}
	}

Of course I have included a bunch of other files which add a bunch more stuff.

Look over the example controller (which should be up to date to get a idea)

Also take a look at the hooks.php file. This is used to extend application.php without having to extend or modify the application.php file (again to keep it simple).

Note the application pretty much is a object of values you can use.

These include:

* run_code (code sent in from index this could be dev, test, production, etc...)
* path (path of the application.php file and in effect app folder)
* is_ajax (is this a ajac call)
* base_url (base_url of the website http://www.here.com)
* raw_request (raw request get, post, delete, put)
* request (router modified rquest)
* raw_uri (raw uri /controller/method/arg1/arg2)
* uri (router modified uri)
* controller (controller section (1) of uri)
* method (method section (2) of uri)
* segs (everything after controller & method sections)
* main_controller (object - main controller called)

The main controller is really nothing more then a php class

In addition the Application autoload follows the following conventions

uppercase first letter = Library folder

$foo = new Bar();

lowercase first letter = Model

$fooModel = new foo();

suffix Controller  = Controller Folder

$bar = new fooController();