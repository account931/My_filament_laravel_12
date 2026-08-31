{{-- @extends('layouts.app') --}}   {{-- Laravel 12 fix--}}
{{-- @section('content') --}}

<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Prism AI agent') }}
		</h2>
	</x-slot>

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-md-12">
				<div class="card">

					<div class="card-header" style="word-break: break-word;">
						Ai agent on Gemeni using Prism package </br>
						<span class="small"> GEMINI_API_KEY ig reged to i**.d***y.i***@g</span>
					</div>

					<div class="card-body">

						@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
						@endif

						<div>

							<p>
								<i class="fas fa-user-circle"></i> Hello, <strong>{{Auth::user()->name}}</strong>
							</p>

							<div class="row">

								<div class="col-lg-9 col-md-9 col-sm-9">
									<!--<p>Owner records via Vue go here.....</p>-->
								</div>


								<!-- Flash message success -->
								@if(session()->has('flashSuccess'))
									<div class=" row alert alert-success">
										<i class='fas fa-charging-station' style='font-size:21px'></i> &nbsp;
										{{ session()->get('flashSuccess') }}
									</div>
								@endif


								<!-- Flash message failure -->
								@if(session()->has('flashFailure'))
									<div class="row alert alert-danger">
										{{ session()->get('flashFailure') }}
									</div>
								@endif

							</div>


							<div class="prism-section">

								<h6><b>Using Prism package <b></h6>

                                <!-- Replies from AI-->
								<div id="messages">

									<div class="message assistant">
										<div class="message-content">
											<i class="fas fa-users"></i>
											Hello! I am your hardcore AI agent. 
											<span class="small">
											Ask me to find/list a user, users role, list shop products or ask about dnb, UA cities, cats, etc.
                                            </span>
										</div>
									</div>

								</div>

                                <!-- Chat form -->
								<form id="chat-form" class="chat-input">
									<input type="text" id="message" placeholder="Ask something..." autocomplete="off">
									<button id="send" type="submit"> Send </button>
								</form>



							</div> <!-- end of  .prism-section -->


						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<script>

	</script>

{{-- @endsection --}}   {{-- Laravel 12 fix--}}

</x-app-layout>


<style>

	/* =========================================
	   Chat
	   ========================================= */
	#messages {
		flex: 1;
		overflow-y: auto;
		padding: 25px;
	}

	.message {
		margin-bottom: 20px;
		display: flex;
	}

	.message.user {
		justify-content: flex-end;
	}

	.message-content {
		max-width: 75%;
		padding: 12px 16px;
		border-radius: 12px;
		line-height: 1.5;
		white-space: pre-wrap;
	}

	.user .message-content {
		background: #2563eb;
		color: white;
	}

	.assistant .message-content {
		background: #f3f4f6;
		color: #111827;
	}

	.chat-input {
		border-top: 1px solid #e5e7eb;
		padding: 15px;
		display: flex;
		gap: 10px;
	}

	#message {
		flex: 1;
		padding: 12px;
		border: 1px solid #d1d5db;
		border-radius: 8px;
		font-size: 16px;
	}

	#send {
		background: #2563eb;
		color: white;
		border: none;
		padding: 0 25px;
		border-radius: 8px;
		cursor: pointer;
		font-size: 16px;
	}

	#send:disabled {
		background: #9ca3af;
		cursor: not-allowed;
	}

	.typing {
		color: #6b7280;
		font-style: italic;
	}




	/* =========================================
	   PRISM AI - BRIGHT UI
	   ========================================= */

	body {
		background: #f0f4ff !important;
		color: #1e293b;
	}

	/* Main container */

	.container {
		max-width: 1250px !important;
		padding-top: 35px;
		padding-bottom: 50px;
	}


	/* =========================================
	   MAIN CARD
	   ========================================= */

	.container .card {
		border: none !important;
		border-radius: 22px !important;
		overflow: hidden;

		background: #ffffff !important;

		box-shadow:
			0 10px 25px rgba(79, 70, 229, 0.08),
			0 25px 60px rgba(59, 130, 246, 0.08) !important;
	}


	/* =========================================
	   CARD HEADER
	   ========================================= */

	.container .card-header {
		position: relative;

		padding: 24px 30px !important;

		border: none !important;

		color: #ffffff !important;

		font-size: 18px;
		font-weight: 700;

		background:
			linear-gradient(
				120deg,
				#7c3aed 0%,
				#6366f1 45%,
				#3b82f6 100%
			) !important;

		box-shadow:
			0 5px 20px rgba(99, 102, 241, 0.25);
	}


	.container .card-header::after {
		content: "";

		position: absolute;

		width: 180px;
		height: 180px;

		right: -70px;
		top: -90px;

		border-radius: 50%;

		background: rgba(255, 255, 255, 0.12);
	}


	/* =========================================
	   CARD BODY
	   ========================================= */

	.container .card-body {
		padding: 35px !important;
		background: #ffffff !important;
	}


	/* =========================================
	   HELLO USER
	   ========================================= */

	.container .card-body > div > p {
		display: flex;
		align-items: center;

		margin: 0 0 30px 0 !important;
		padding: 17px 20px;

		border-radius: 14px;

		background:
			linear-gradient(
				135deg,
				#f5f3ff,
				#eef2ff,
				#eff6ff
			);

		border: 1px solid #e0e7ff;

		color: #475569;

		font-size: 16px;

		box-shadow:
			0 4px 15px rgba(99, 102, 241, 0.06);
	}


	.container .card-body > div > p .fa-user-circle {
		margin-right: 10px;

		color: #6366f1;

		font-size: 24px;
	}


	.container .card-body > div > p strong {
		margin-left: 5px;

		color: #4f46e5;

		font-weight: 700;
	}


	/* =========================================
	   INNER ROW
	   ========================================= */

	.container .card-body .row {
		margin-left: 0;
		margin-right: 0;
	}


	/* =========================================
	   SUCCESS MESSAGE
	   ========================================= */

	.container .alert-success {
		border: none !important;
		border-left: 5px solid #22c55e !important;

		border-radius: 12px !important;

		background:
			linear-gradient(
				135deg,
				#ecfdf5,
				#dcfce7
			) !important;

		color: #166534 !important;

		padding: 15px 18px !important;

		box-shadow:
			0 5px 18px rgba(34, 197, 94, 0.10);
	}


	.container .alert-success .fa-charging-station {
		color: #16a34a !important;
	}


	/* =========================================
	   ERROR MESSAGE
	   ========================================= */

	.container .alert-danger {
		border: none !important;
		border-left: 5px solid #ef4444 !important;

		border-radius: 12px !important;

		background:
			linear-gradient(
				135deg,
				#fff1f2,
				#fee2e2
			) !important;

		color: #991b1b !important;

		padding: 15px 18px !important;

		box-shadow:
			0 5px 18px rgba(239, 68, 68, 0.10);
	}


	/* =========================================
	   PRISM SECTION
	   ========================================= */

	.prism-section {
		position: relative;

		min-height: 220px;

		margin-top: 30px;
		padding: 30px;

		overflow: hidden;

		border-radius: 20px;

		background:
			radial-gradient(
				circle at 90% 10%,
				rgba(139, 92, 246, 0.22),
				transparent 30%
			),
			radial-gradient(
				circle at 10% 90%,
				rgba(59, 130, 246, 0.16),
				transparent 30%
			),
			linear-gradient(
				135deg,
				#faf5ff 0%,
				#eef2ff 45%,
				#eff6ff 100%
			);

		border: 1px solid #ddd6fe;

		box-shadow:
			0 8px 30px rgba(99, 102, 241, 0.08),
			inset 0 1px 0 rgba(255, 255, 255, 0.9);
	}


	.prism-section::before {
		content: "";

		position: absolute;

		width: 100px;
		height: 100px;

		top: -40px;
		right: 50px;

		border-radius: 50%;

		background: rgba(124, 58, 237, 0.08);
	}


	.prism-section::after {
		content: "";

		position: absolute;

		width: 70px;
		height: 70px;

		bottom: -25px;
		left: 40px;

		border-radius: 50%;

		background: rgba(59, 130, 246, 0.08);
	}


	/* =========================================
	   PRISM TITLE
	   ========================================= */

	.prism-section h6 {
		position: relative;
		z-index: 2;

		margin: 0;

		color: #6d28d9;

		font-size: 20px;
		font-weight: 700;

		letter-spacing: 0.3px;
	}


	.prism-section h6 b {
		color: #6d28d9;
	}


	/* =========================================
	   ALERT ANIMATION
	   ========================================= */

	.alert {
		animation: prismFadeIn 0.35s ease-out;
	}


	@keyframes prismFadeIn {

		from {
			opacity: 0;
			transform: translateY(-5px);
		}

		to {
			opacity: 1;
			transform: translateY(0);
		}

	}


	/* =========================================
	   RESPONSIVE
	   ========================================= */

	@media (max-width: 768px) {

		.container {
			padding-top: 20px;
			padding-left: 15px;
			padding-right: 15px;
		}

		.container .card-header {
			padding: 20px !important;
			font-size: 16px;
		}

		.container .card-body {
			padding: 20px !important;
		}

		.prism-section {
			min-height: 180px;
			padding: 22px;
		}

		.container .card-body > div > p {
			font-size: 14px;
		}

	}


	/* =========================================
	   SMALL SCREENS
	   ========================================= */

	@media (max-width: 480px) {

		.container .card {
			border-radius: 16px !important;
		}

		.container .card-header {
			padding: 18px !important;
		}

		.container .card-body {
			padding: 15px !important;
		}

		.prism-section {
			margin-top: 20px;
			min-height: 160px;
			padding: 18px;
			border-radius: 15px;
		}

	}

</style>







<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>  <!-- mark down library -->

<script>
	

	const form = document.getElementById('chat-form');
	const input = document.getElementById('message');
	const messages = document.getElementById('messages');
	const sendButton = document.getElementById('send');

	function addMessage(message, type)
    {
      const wrapper = document.createElement('div');
      wrapper.className = `message ${type}`;
      const content = document.createElement('div');
      content.className = 'message-content';

      if (type === 'assistant') {
        content.innerHTML = marked.parse(message);
      } else {
        content.textContent = message;
      }

      wrapper.appendChild(content);
      messages.appendChild(wrapper);
      messages.scrollTop = messages.scrollHeight;

      return wrapper;
    }

	form.addEventListener('submit', async function(event)
	{
		event.preventDefault();

		const message = input.value.trim();

		if (!message) {
			return;
		}

		addMessage(message, 'user');

		input.value = '';

		sendButton.disabled = true;

		const typing = addMessage('Thinking...', 'assistant');

		typing.querySelector('.message-content')
			.classList.add('typing');

		try {

			const response = await fetch(
				'{{ route('ai-agent.chat') }}',
				{
					method: 'POST',

					headers: {
						'Content-Type': 'application/json',
						'Accept': 'application/json',
						'X-CSRF-TOKEN':
							document
								.querySelector('meta[name="csrf-token"]')
								.getAttribute('content')
					},

					body: JSON.stringify({
						message: message
					})
				}
			);

			const data = await response.json();

			typing.remove();

			if (!response.ok) {
				addMessage(
					data.message ?? 'Something went wrong.',
					'assistant'
				);

				return;
			}

			addMessage(
				data.message,
				'assistant'
			);

		} catch (error) {

			typing.remove();

			addMessage(
				'Could not connect to the AI server.',
				'assistant'
			);

			console.error(error);

		} finally {

			sendButton.disabled = false;

			input.focus();
		}
	});

</script>