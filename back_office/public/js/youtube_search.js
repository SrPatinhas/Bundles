
	$(function() {
		$(document).ready(function(){

			function tog(v){return v?'addClass':'removeClass';}

			$(".search_input_youtube").focus(function() {
				$(".search_input_youtube").val($("#nome").val() + ' trailer');
				$(".search_input_youtube").keyup();
				$(this)[tog(this.value)]('x');
			});
			
			$(document).on('input', '.clear_input', function(){
				$(this)[tog(this.value)]('x');
			}).on('mousemove', '.x', function( e ){
				$(this)[tog(this.offsetWidth-25 < e.clientX-this.getBoundingClientRect().left)]('onX');   
			}).on('click', '.onX', function(){
				$(this).removeClass('x onX').val('');
				if ($(this).attr('id') == "pesquisa_youtube") {
					$(".search_input_youtube").keyup();
				};
			});

			$(".search_input_youtube").keyup(function() { 
			 	$("#video_youtube").html('');
				var search_input = $(this).val();
				var keyword= encodeURIComponent(search_input);
				if (search_input != '') {
					$(".clear_youtube").css('display', 'block');
					$("#video_youtube").removeClass('video_up_youtube');
					$("#pesquisa_youtube").addClass('search_youtube');
					var yt_url='http://gdata.youtube.com/feeds/api/videos?q='+keyword+'&format=5&max-results=6&v=2&alt=jsonc';  
					$.ajax({
						type: "GET",
						url: yt_url,
						dataType:"jsonp",
						success: function(response){
							if(response.data.items){
								$.each(response.data.items, function(i,data){
									var video_id=data.id;
									var video_title=data.title;
									var video_viewCount=data.viewCount;
									var video_frame="<iframe width='340' height='200' src='http://www.youtube.com/embed/"+video_id+"' frameborder='0' type='text/html'></iframe>";
									var button_add = "<button type='button' class='btn btn-success btn-sm add_video_youtube' rel-link='http://www.youtube.com/embed/"+video_id+"' ><span style='color:white;' class='glyphicon glyphicon-plus'></span></button>";
									var final="<div id='result_youtube'><div>"+video_frame+"</div><div id='title_youtube'>"+video_title+"</div><div id='count_youtube'>"+video_viewCount+" Views</div>"+button_add+"</div>";
									$("#video_youtube").append(final);
								});
							} else {
								$("#video_youtube").html("<div id='no_youtube'>No Video</div>");
							}
						}
					}); 
				} else {
					$("#video_youtube").html('');
					$(".clear_youtube").css('display', 'none');
					$("#video_youtube").addClass('video_up_youtube');
					$("#pesquisa_youtube").removeClass('search_youtube');
				}
			});
		});
	});