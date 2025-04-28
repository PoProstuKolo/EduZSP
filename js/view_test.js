let outsideClickCount = 0

function startTimer(duration) {
	let timer = duration,
		minutes,
		seconds
	const countdownElement = document.getElementById('countdown')

	const countdownInterval = setInterval(function () {
		minutes = parseInt(timer / 60, 10)
		seconds = parseInt(timer % 60, 10)

		minutes = minutes < 10 ? '0' + minutes : minutes
		seconds = seconds < 10 ? '0' + seconds : seconds

		countdownElement.textContent = minutes + ':' + seconds

		if (--timer < 0) {
			clearInterval(countdownInterval)
			document.getElementById('testForm').submit() // Automatyczne przesłanie formularza po zakończeniu czasu
		}
	}, 1000)
}

document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll('.question__answer').forEach(input => {
		input.addEventListener('change', function () {
			document.querySelectorAll(`input[name="${this.name}"]`).forEach(radio => {
				radio.closest('.question__label').classList.remove('checked')
			})

			if (this.checked) {
				this.closest('.question__label').classList.add('checked')
			}
		})
	})
})
