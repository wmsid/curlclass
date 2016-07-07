<?php
class WmCurl
{
	private $ch;
	private $body;
	private $header;
	function call($url,$post="",$cookie="",$head="",$proxy="")
	{
		$this->ch = curl_init($url);
		if(!$proxy=="")
			curl_setopt($this->ch, CURLOPT_PROXY, $proxy);

		if(!$post=="")
		{
			curl_setopt ($this->ch, CURLOPT_POST, 1);
			curl_setopt ($this->ch, CURLOPT_POSTFIELDS, $post);
		}
		if(!$cookie=="")
		{
			curl_setopt ($this->ch, CURLOPT_COOKIE, $cookie);
		}
		if($head!="")
		{
			curl_setopt( $this->ch, CURLOPT_HTTPHEADER, $head);
		}
		curl_setopt($this->ch, CURLOPT_HEADER, 1);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt ($this->ch, CURLOPT_RETURNTRANSFER, true);

		$response=curl_exec ($this->ch);
		$header_size = curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);
		$this->header = substr($response, 0, $header_size);
		$this->body = substr($response, $header_size);

		curl_close ($this->ch);
	}

	function get()
	{
		return $this->body;
	}

	function geth()
	{
		$contents=explode("\n",$this->header);
		//print_r($contents);
		for($i=0;$i<count($contents);$i++)
		{
			$list=explode(":",$contents[$i]);
			if(count($list)>1 && !isset($head[$list[0]]))
			$head[$list[0]]=$list[1];
		}
		return $head;
	}

}
