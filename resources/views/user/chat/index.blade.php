@extends('layouts.app')
@section('css')
	<!-- Sweet Alert CSS -->
	<link href="{{URL::asset('plugins/sweetalert/sweetalert2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')

<form id="openai-form" action="" method="GET" enctype="multipart/form-data" class="mt-12">		
	@csrf
	<div class="row justify-content-md-center">	
		<div class="col-lg-8 col-md-12 col-sm-12">
			<div class="text-left mb-4" id="balance-status">
				<span class="fs-11 text-muted pl-3"><i class="fa-sharp fa-solid fa-bolt-lightning mr-2 text-primary"></i>{{ __('Your Balance is') }} <span class="font-weight-semibold" id="balance-number">{{ number_format(auth()->user()->available_words + auth()->user()->available_words_prepaid) }}</span> {{ __('Words') }}</span>
			</div>							
		</div>
		<div class="col-lg-8 col-md-12 col-sm-12">
			<div class="card border-0" id="chat-system">
				<div class="card-header">
					<div class="w-100">
						<h3 class="card-title"><i class="fa-solid fa-message-captions mr-2 text-info"></i>{{ __('AI Chat Bot') }}</h3>	
					</div>
					<div class="w-100 text-right">				
						<a id="export-word" class="template-button mr-2" onclick="exportWord();" href="#"><i class="fa-solid fa-file-word table-action-buttons table-action-buttons-big edit-action-button" data-tippy-content="{{ __('Export Chat Conversation as Word File') }}"></i></a>
						<a id="export-pdf" class="template-button mr-2" onclick="exportPDF();" href="#"><i class="fa-solid fa-file-pdf table-action-buttons table-action-buttons-big edit-action-button" data-tippy-content="{{ __('Export Chat Conversation as PDF File') }}"></i></a>
						<a id="export-txt" class="template-button mr-2" onclick="exportTXT();" href="#"><i class="fa-solid fa-file-lines table-action-buttons table-action-buttons-big edit-action-button" data-tippy-content="{{ __('Export Chat Conversation Text File') }}"></i></a>
						<a id="clear" class="template-button" onclick="return clearConversation();" href="#"><i class="fa-solid fa-message-xmark table-action-buttons table-action-buttons-big delete-action-button" data-tippy-content="{{ __('Clear Chat Conversation') }}"></i></a>
						{{-- <a id="save" class="template-button" onclick="return clearConversation();" href="#"><i class="fa-solid fa-message-check table-action-buttons table-action-buttons-big view-action-button" data-tippy-content="{{ __('Save Chat Conversation') }}"></i></a> --}}
					</div>
				</div>
				<div class="card-body pl-0 pr-0">
					<div class="row">						
						<div class="col-md-12 col-sm-12" >
							{{-- <div class="msg left-msg ml-">
								<div class="message-img" style="background-image: url('/img/brand/favicon.png')"></div>
								<div class="message-bubble">
									<div class="msg-text">Some useful text</div>
								</div>
							</div>	 --}}
							<div id="chat-container"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="card border-0">
				<div class="card-body">
					<div class="row">						
						<div class="col-sm-12">	
							
							<div class="input-box mb-0">								
								<div class="input-group file-browser">							    
									<input type="message" class="form-control @error('message') is-danger @enderror border-right-0" style="margin-right: 80px;" id="message" name="message" placeholder="{{ __('Enter your question here...') }}">
									<label class="input-group-btn">
										<button class="btn btn-primary special-btn" id="chat-button">
											{{ __('Send') }}
										</button>
									</label>
								</div> 
								@error('message')
									<p class="text-danger">{{ $errors->first('message') }}</p>
								@enderror
							</div> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection

@section('js')
<script src="{{URL::asset('plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<script src="{{URL::asset('plugins/pdf/html2canvas.min.js')}}"></script>
<script src="{{URL::asset('plugins/pdf/jspdf.umd.min.js')}}"></script>
<script src="{{URL::asset('js/export-chat.js')}}"></script>
<script type="text/javascript">
	const main_form = get("#openai-form");
	const input_text = get("#message");
	const msgerChat = get("#chat-container");
	const msgerSendBtn = get("#chat-button");
	const bot_avatar = "/img/brand/favicon.png";
	const bot_name = "AI Bot";
	const user_avatar = "{{ URL::asset(auth()->user()->profile_photo_path) }}";		
	const user_name = "You";

	$(function () {
		
		main_form.addEventListener("submit", event => {
			event.preventDefault();
			const message = input_text.value;
			if (!message) return;

			appendMessage(user_name, user_avatar, "right", message);
			input_text.value = "";
			process(message)
		});

	});


	function animateValue(id, start, end, duration) {
		if (start === end) return;
		var range = end - start;
		var current = start;
		var increment = end > start? 1 : -1;
		var stepTime = Math.abs(Math.floor(duration / range));
		var obj = document.getElementById(id);
		var timer = setInterval(function() {
			current += increment;
			if (current > 0) {
				obj.innerHTML = current;
			} else {
				obj.innerHTML = 0;
			}
			
			if (current == end) {
				clearInterval(timer);
			}
		}, stepTime);
	}

	function saveText(event) {

		//let textarea = document.querySelector('.richText-editor').textContent;
		let textarea = document.getElementById('codetext').innerHTML;
		let title = document.getElementById('document').value;


		if (!event.target) {
			toastr.warning('{{ __('You will need to generate AI code first before saving') }}');
		} else {
			$.ajax({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				method: 'POST',
				url: '/user/code/save',
				data: { 'id': event.target, 'text': textarea, 'title': title},
				success: function (data) {					
					if (data['status'] == 'success') {
						toastr.success('{{ __('Code has been successfully saved') }}');
					} else {						
						toastr.warning('{{ __('There was an issue while saving your code') }}');
					}
				},
				error: function(data) {
					toastr.warning('{{ __('There was an issue while saving your code') }}');
				}
			});

			return false;
		}

	}

	
	function process(message) {
		msgerSendBtn.disabled = true
		let formData = new FormData();
		formData.append('message', message);

		fetch('/user/chat/process', {
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				method: 'POST', 
				body: formData
			})		
			.then(response => response.json())
			.then(function(result){
				
				if (result['old'] && result['current']) {
					animateValue("balance-number", result['old'], result['current'], 300);
				}
		
				if (result['status'] == 'error') {
					Swal.fire('{{ __('Chat Notification') }}', result['message'], 'warning');
				}
			})	
			.then(data => {
				
				let code = makeid(10);
				const eventSource = new EventSource("/user/chat/generate", {withCredentials: true});
				appendMessage(bot_name, bot_avatar, "left", "", code);
				const response = document.getElementById(code);

				eventSource.onmessage = function (e) {

					if (e.data == "[DONE]") {
						msgerSendBtn.disabled = false
						eventSource.close();

					} else {
						let txt = JSON.parse(e.data).choices[0].delta.content
						if (txt !== undefined) {
							response.innerHTML += txt.replace(/(?:\r\n|\r|\n)/g, '<br>');
						}
					}
				};
				eventSource.onerror = function (e) {
					msgerSendBtn.disabled = false
					console.log(e);
					eventSource.close();
				};
				
			})
			.catch(function (error) {
				console.log(error);
			});

	}

	function clearConversation() {
		document.getElementById("chat-container").innerHTML = "";

		fetch('/user/chat/clear', {
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				method: 'POST', 
			})		
			.then(response => response.json())
			.then(function(result){

				if (result.status == 'success') {
					toastr.success('{{ __('Chat conversation has been cleared successfully') }}');
				}

			})	
			.catch(function (error) {
				console.log(error);
			});
	}


	function appendMessage(name, img, side, text, code) {

		const msgHTML = `
		<div class="msg ${side}-msg">
		<div class="message-img" style="background-image: url(${img})"></div>
		<div class="message-bubble">
			<div class="msg-info">
			<div class="msg-info-name">${name}</div>
			<div class="msg-info-time">${formatDate(new Date())}</div>
			</div>

			<div class="msg-text" id="${code}">${text}</div>
		</div>
		</div>`;

		msgerChat.insertAdjacentHTML("beforeend", msgHTML);
		msgerChat.scrollTop += 500;
	}

	function get(selector, root = document) {
		return root.querySelector(selector);
	}

	function formatDate(date) {
		const h = "0" + date.getHours();
		const m = "0" + date.getMinutes();

		return `${h.slice(-2)}:${m.slice(-2)}`;
	}

	function deleteAllCookies() {
		const cookies = document.cookie.split(";");

		for (let i = 0; i < cookies.length; i++) {
			const cookie = cookies[i];
			const eqPos = cookie.indexOf("=");
			const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
			document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
		}
	}

	function makeid(length) {
		let result = '';
		const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		const charactersLength = characters.length;
		let counter = 0;
		while (counter < length) {
		result += characters.charAt(Math.floor(Math.random() * charactersLength));
		counter += 1;
		}
		return result;
	}
</script>
@endsection