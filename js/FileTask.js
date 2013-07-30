function FileTask(file) {
	if (typeof file == 'object') {
	    for (var key in file) {
	        this[key] = file[key];
	    }
	} else {
        this.file = file;
    	this.lines = -1;
    	this.processed = -1;
	}
}