<?php

function
CanHasIter(Iterable $Stuff):
Void {
/*//
this function is designed to process anything that is loopable and tell you
about it before hand.
//*/

	if(is_array($Stuff))
	echo 'by array', PHP_EOL;

	else
	printf(
		'by %s%s',
		get_class($Stuff),
		PHP_EOL
	);

	echo '> ';
	foreach($Stuff as $Thing)
	echo $Thing, ' ';

	echo PHP_EOL;
	return;
}

function
ImAnGenerator() {
/*//
a simple generator that serves no real purpose other than demo.
//*/

	for($A = 1; $A <= 3; $A++)
	yield $A;
}

class Pile
implements Iterator {
/*//
this class will implement the Iterator interface so that it can be used against
a protected dataset, allowing you to loop upon the object but really loop upon
the dataset instead. we will also implement a few other methods just for show.
//*/

	protected
	$Data = [];

	public function
	GetData():
	Array {

		return $this->Data;
	}

	public function
	SetData(Array $Dataset):
	self {
		$this->Data = $Dataset;
		return $this;
	}

	////////
	////////

	// methods implementing the Iterator interaface

	public function
	Current() {
	/*//
	get the current value the internal pointer is sitting on.
	//*/

		return current($this->Data);
	}

	public function
	Key() {
	/*//
	get the key name that the internal pointer is sitting on.
	//*/

		return key($this->Data);
	}

	public function
	Next() {
	/*//
	advance the internal pointer.
	//*/

		return next($this->Data);
	}

	public function
	Rewind() {
	/*//
	reset the intiernal pointer.
	//*/

		return reset($this->Data);
	}

	public function
	Valid() {
	/*//
	check if we have hit the end of the dataset yet.
	//*/

		return (key($this->Data) !== NULL);
	}

	////////
	////////

	// other methods cause its an object. they are just because they are not
	// required by the Iterator interface.

	public function
	Count():
	Int {
	/*//
	simple count of the dataset.
	//*/

		return count($this->Data);
	}

	public function
	StartsWithVowel():
	self {
	/*//
	filter down the dataset to only strings which begin with a vowel. it will
	return a new Pile object wrapping the filtered dataset.
	//*/

		return (new static)
		->SetData(array_filter(
			$this->Data,
			function($Value): Bool {
				if(!is_string($Value))
				return FALSE;

				if(!preg_match('/^[aeiou]/i',$Value))
				return FALSE;

				return TRUE;
			}
		));
	}

}

$Stuff = [ 'omg','wtf','bbq' ];
$Pile = (new Pile)->SetData($Stuff);

// give it a direct array.
CanHasIter([1,2,3]);

// give it an array variable.
CanHasIter($Stuff);

// give it an iterable object.
CanHasIter($Pile);

// give it an iterable object.
CanHasIter($Pile->StartsWithVowel());

// give it a generator.
CanHasIter(ImAnGenerator());

// give it a string. (intentional error)
CanHasIter('omfg');
