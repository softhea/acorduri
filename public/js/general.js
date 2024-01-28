document.addEventListener('DOMContentLoaded', function () {
	function getOffset(element) 
	{
		const offset = element.getBoundingClientRect();

		return {
		  	left: offset.left + window.scrollX,
		  	top: offset.top + window.scrollY
		};
	}

	function setTopAndLeftAndShow(event)
	{
		let link = event.currentTarget;
		let offset = getOffset(link);

		let chordId = link.getAttribute('chord_id')
		let chord = document.getElementById(chordId);

		chord.style.top = offset.top + 'px';
		chord.style.left = offset.left + 30 + 'px';

		chord.style.display = 'block';
	}

	function hide(chordId) 
	{
		let chord = document.getElementById(chordId);

		chord.style.display = 'none';
	}

	const elements = document.getElementsByClassName('chord');
	for (let element of elements) {
		element.addEventListener("mouseover", function (event) {
			setTopAndLeftAndShow(event);
		});

		element.addEventListener("mouseout", function (event) {
			hide(event.currentTarget.getAttribute('chord_id'));
		});
	};

	const deleteButtons = document.getElementsByClassName('delete-button');
	for (const deleteButton of deleteButtons) {
		deleteButton.onclick = function () {
			return confirm("Confirm?");
		}
	};
}, false);
