<?php
class Pool extends HttpRequestPool
{
	public function __construct()
	{
		parent::__construct(
			new HttpRequest('http://pear.php.net', HTTP_HEAD),
			new HttpRequest('http://pecl.php.net', HTTP_HEAD)
		);

		// HttpRequestPool methods socketPerform() and socketSelect() are
		// protected;  one could use this approach to do something else
		// while the requests are being executed
		print "Executing requests";
		for ($i = 0; $this->socketPerform(); $i++) {
			$i % 3 or print ".";
			if (!$this->socketSelect()) {
				throw new HttpException("Socket error!");
			}
		}
		print "\nDone!\n";
	}
}

try {
	foreach (new Pool as $r) {
		print "Checking ", $r->getUrl(), " reported ", $r->getResponseCode(), "\n";
	}
} catch (HttpException $ex) {
	print $e;
}
?>
