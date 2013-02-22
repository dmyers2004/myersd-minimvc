I tried to make this framework as simple as possible.

in addition to the empty folder structure the only files needs are index.php and application.php

The .htaccess sends everything to index.php and index.php loads application.php file which in turn loads the correct controller and method.

The most basic controller is

<pre>

class mainController {

	public function indexAction() {
		echo('Controller Loaded and Something Echoed Out<pre>');
	}

}
</pre>

Of course I have included a bunch of other files which add a bunch more stuff.

Look over the example controller (which should be up to date to get a idea)

also take a look at the hooks.php file. This is used to extend application.php without having to extend or modify the application.php file.

