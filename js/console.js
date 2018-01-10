/**
 * Display the Virtual Machine Console 
 * Send proper request to "console.php" page responsible for managing
 * console of VM
 *
 */

$(function(){
	//alert("Hi");
	$('#start-console').on('click',function(){
		//alert("start");
		var vmname = $('#VMname').html();
		//alert(vmname);
		$.get('console.php?VM_name='+vmname+'&operation=start',function(data){
			window.open(data,'_blank');
		});

	});

	$('#delete-console').on('click',function(){
		
		var vmname = $('#VMname').html();
		$.get('console.php?VM_name='+vmname+'&operation=stop',function(data){
			$('#console-frame').html('');
		});
	});
});