<?php

class Cachemanager extends MX_Controller
{
	private $itemMatches;
	private $websiteMatches;
	private $messageMatches;

	public function __construct()
	{
		// Make sure to load the administrator library!
		$this->load->library('administrator');

		$this->itemMatches = array("spells/*", "items/*", "search/*");
		$this->websiteMatches = array("*.cache");
		$this->messageMatches = array("messages/*");

		parent::__construct();

		requirePermission("viewCache");
	}

	public function index()
	{
		// Change the title
		$this->administrator->setTitle("مدیریت کش ها");

		// Prepare my data
		$data = array(
			'url' => $this->template->page_url
		);

		// Load my view
		$output = $this->template->loadPage("cachemanager/cache.tpl", $data);

		// Put my view in the main box with a headline
		$content = $this->administrator->box('مدیریت کش ها', $output);

		// Output my content. The method accepts the same arguments as template->view
		$this->administrator->view($content, false, "modules/admin/js/cache.js");
	}

	public function get()
	{
		$item = $this->countItemCache();
		$website = $this->countWebsiteCache();
		$message = $this->countMessageCache();

		$total['files'] = $item['files'] + $website['files'] + $message['files'];
		$total['size'] = $this->formatSize($item['size'] + $website['size'] + $message['size']);

		// Prepare my data
		$data = array(
			'url' => $this->template->page_url,
			'item' => $item,
			'website' => $website,
			'message' => $message,
			'total' => $total
		);

		// Load my view
		$output = $this->template->loadPage("cachemanager/cache_data.tpl", $data);

		die($output);
	}

	private function countItemCache()
	{
		// Define our result
		$result = array(
			"files" => 0,
			"size" => 0
		);

		// Define what to search for
		$matches = $this->itemMatches;
		
		// Loop through all searches
		foreach($matches as $search)
		{
			// Search for matches
			$matches = glob("application/cache/data/".$search);

			if($matches)
			{
				// Loop through all matches
				foreach($matches as $file)
				{
					if(!preg_match("/index\.html/", $file))
					{
						// Count and add their size to the result
						$result['files']++;
						$result['size'] += filesize($file);
					}
				}
			}
		}

		$result['sizeString'] = $this->formatSize($result['size']);

		return $result;
	}

	private function countWebsiteCache()
	{
		// Define our result
		$result = array(
			"files" => 0,
			"size" => 0
		);

		// Define what to search for
		$matches = $this->websiteMatches;

		// Loop through all searches
		foreach($matches as $search)
		{
			// Search for matches
			$matches = glob("application/cache/data/".$search);

			if($matches)
			{
				// Loop through all matches
				foreach($matches as $file)
				{
					if(!preg_match("/index\.html/", $file))
					{
						// Count and add their size to the result
						$result['files']++;
						$result['size'] += filesize($file);
					}
				}
			}
		}

		$result['sizeString'] = $this->formatSize($result['size']);

		return $result;
	}

	private function countMessageCache()
	{
		// Define our result
		$result = array(
			"files" => 0,
			"size" => 0
		);

		// Define what to search for
		$matches = $this->messageMatches;

		// Loop through all searches
		foreach($matches as $search)
		{
			// Search for matches
			$matches = glob("application/cache/data/".$search);

			if($matches)
			{
				// Loop through all matches
				foreach($matches as $file)
				{
					if(!preg_match("/index\.html/", $file))
					{
						// Count and add their size to the result
						$result['files']++;
						$result['size'] += filesize($file);
					}
				}
			}
		}

		$result['sizeString'] = $this->formatSize($result['size']);

		return $result;
	}


	private function formatSize($size)
	{
		if($size < 1024)
		{
			return $size." B";
		}
		elseif($size < 1024 * 1024)
		{
			return round($size / 1024)." KB";
		}
		elseif($size < 1024 * 1024 * 1024)
		{
			return round($size / (1024 * 1024))." MB";
		}
		else
		{
			return round($size / (1024 * 1024 * 1024))." GB";
		}
	}

	public function delete($type = false)
	{
		requirePermission("emptyCache");
		
		if(!$type || !in_array($type, array('all_but_item', 'website', 'message', 'all')))
		{
			die();
		}
		else
		{
			switch($type)
			{
				case "all_but_item":
					foreach($this->messageMatches as $match)
					{
						$this->cache->delete($match);
					}

					foreach($this->websiteMatches as $match)
					{
						$this->cache->delete($match);
					}
				break;

				case "website":
					foreach($this->websiteMatches as $match)
					{
						$this->cache->delete($match);
					}
				break;

				case "message":
					foreach($this->messageMatches as $match)
					{
						$this->cache->delete($match);
					}
				break;

				case "all":
					$this->cache->deleteAll();
				break;
			}

			die("با موفقیت انجام شد");
		}
	}
}