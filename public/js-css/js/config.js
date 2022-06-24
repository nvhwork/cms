function checkExists(path, arrays, mac) {
	for(i=0; i<arrays.length; i++){
		if(arrays[i][1] == mac) continue;
		if(arrays[i][4] == path)
			return 1;
	}
	return 0;
}