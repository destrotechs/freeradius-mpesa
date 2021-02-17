$(document).ready(function(){
	var usernames=["morr","destro","mike","nyag"];
	// $.ajax({
	// 	method:'post',
	// 	url:'../all/usernames',
	// 	data:{_token:_token},
	// 	success:function(data){
	// 		for(var i=0;i<data.length;i++){
	// 			usernames.push(data[i]);
	// 		}
	// 	}
	// })

	$(".username").on("keyup",function(){
		
		var skey=$(this).val();
		var _token=$("input[name='_token']").val();
		if (skey!="") {
			$.ajax({
				method:'post',
				url:"../home/autocomplete",
				data:{_token:_token,skey:skey},
				success:function(data){
					$("#users").html(data);
					$(".users").html(data);
					$("#users").show();
				}
			})
		}
	})
	$(document).on("click","p",function(){
		var username=$(this).html();
		$(".username").val(username);
		$("#users").hide();
	})
});