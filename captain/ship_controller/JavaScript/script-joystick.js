

class JoystickController
{
	// stickID: ID of HTML element (representing joystick) that will be dragged
	// maxDistance: maximum amount joystick can move in any direction
	// deadzone: joystick must move at least this amount from origin to register value change
	constructor( stickID, maxDistance, deadzone )
	{
		this.id = stickID;
		let stick = document.getElementById(stickID);
        console.log("Le ID est :", stick)

		// location from which drag begins, used to calculate offsets
		this.dragStart = null;

		// track touch identifier in case multiple joysticks present
		this.touchId = null;
		
		this.active = false;
		this.value = { x: 0, y: 0 };

		// lock joystick position flag
		this.locked = false;

		let self = this;

		function handleDown(event)
		{
			if (self.locked) return;

		    self.active = true;

			// alldrag movements are instantaneous
			stick.style.transition = '0s';

			// touch event fired before mouse event; prevent redundant mouse event from firing
			event.preventDefault();

		    if (event.changedTouches)
		    	self.dragStart = { x: event.changedTouches[0].clientX, y: event.changedTouches[0].clientY };
		    else
		    	self.dragStart = { x: event.clientX, y: event.clientY };

			// if this is a touch event, keep track of which one
		    if (event.changedTouches)
		    	self.touchId = event.changedTouches[0].identifier;
		}
		
		function handleMove(event) 
		{
		    if ( !self.active ) return;

		    // if this is a touch event, make sure it is the right one
		    // also handle multiple simultaneous touchmove events
		    let touchmoveId = null;
		    if (event.changedTouches)
		    {
		    	for (let i = 0; i < event.changedTouches.length; i++)
		    	{
		    		if (self.touchId == event.changedTouches[i].identifier)
		    		{
		    			touchmoveId = i;
		    			event.clientX = event.changedTouches[i].clientX;
		    			event.clientY = event.changedTouches[i].clientY;
		    		}
		    	}

		    	if (touchmoveId == null) return;
		    }

		    const xDiff = event.clientX - self.dragStart.x;
		    const yDiff =event.clientY - self.dragStart.y;

		    // if joystick is locked, do not update position
		    if (self.locked) return;

		    const angle = Math.atan2(yDiff, xDiff);
			const distance = Math.min(maxDistance, Math.hypot(xDiff, yDiff));
			const xPosition = distance * Math.cos(angle);
			const yPosition = distance * Math.sin(angle);

			// move stick image to new position
		    stick.style.transform = `translate3d(${xPosition}px, ${yPosition}px, 0px)`;

			// deadzone adjustment
			const distance2 = (distance < deadzone) ? 0 : maxDistance / (maxDistance - deadzone) * (distance - deadzone);
		    const xPosition2 = distance2 * Math.cos(angle);
			const yPosition2 = distance2 * Math.sin(angle);
		    const xPercent = parseFloat((xPosition2 / maxDistance).toFixed(4));
		    const yPercent = parseFloat((yPosition2 / maxDistance).toFixed(4));
		    
		    self.value = { x: xPercent, y: yPercent };
		  }

		function handleUp(event) 
		{
		    if ( !self.active ) return;

		    // if this is a touch event, make sure it is the right one
		    if (event.changedTouches && self.touchId != event.changedTouches[0].identifier) return;

		    // transition the joystick position backto center only if joystick is not locked
		    if (!self.locked) {
			    stick.style.transition = '.2s';
			    stick.style.transform = `translate3d(0px, 0px, 0px)`;
			}

		    // reset everything except the lock flag
		    self.value = { x: 0, y: 0 };
		    self.touchId = null;
		    self.active = false;
		}

        function handleUp2(event) 
        {
            if (!self.active) return;

            // if this is a touch event, make sure it is the right one
            if (event.changedTouches && self.touchId != event.changedTouches[0].identifier) return;
        
            // transition the joystick position back to center only if joystick is not locked
            if (!self.locked) {
            stick.style.transition = ".2s";
            // Get the current position of the joystick
            const currentPosition = stick.style.transform;
            // Set the joystick position to the current position
            stick.style.transform = currentPosition;
            }
        
            // reset everything except the lock flag
            self.value = {
            x: parseFloat((stick.style.transform.split("(")[1].split("px")[0] / maxDistance).toFixed(4)),
            y: parseFloat((stick.style.transform.split(", ")[1].split("px")[0] / maxDistance).toFixed(4))
            };
            self.touchId = null;
            self.active = false;
        }

		stick.addEventListener('mousedown', handleDown);
		stick.addEventListener('touchstart', handleDown);
		document.addEventListener('mousemove', handleMove, {passive: false});
		document.addEventListener('touchmove', handleMove, {passive: false});
        if (stick == document.getElementById("stick2")) {
            document.addEventListener('mouseup', handleUp);
            document.addEventListener('touchend', handleUp);
        } else {
            document.addEventListener('mouseup', handleUp2);
            document.addEventListener('touchend', handleUp2);
        }

	}
}

let joystick1 = new JoystickController("stick1", 64, 8);
let joystick2 = new JoystickController("stick2", 64, 8);

let lockButton = document.getElementById("mySwitch");
let isLocked = false;

joystick1.locked = false;
joystick2.locked = true;

lockButton.addEventListener('click', function() {
    isLocked = !isLocked;
    //joystick1.locked = isLocked;
    //joystick2.locked = isLocked;

    if (lockButton.checked) {
        //lockButton.textContent = "Fixed"
        //lockButton.style.backgroundColor = "#d53838"
        joystick1.locked = true;
        joystick2.locked = false;
    } else {
        //lockButton.textContent = "Not fixed"
        //lockButton.style.backgroundColor = "#5068ab"
        
		joystick1.locked = false;
        joystick2.locked = true;
    }
});

var axeX = 0.0;
var axeY = 0.0;
var angle = 0.0;



function update()
{
	const table1 = JSON.parse(JSON.stringify(joystick1.value));
	const table2 = JSON.parse(JSON.stringify(joystick2.value));

	const dataJ1 = Object.values(table1);
	const dataJ2 = Object.values(table2);

	//Calcul de l'angle
	const angleRadians1 = Math.atan2(-dataJ1[1], dataJ1[0]);
	const angleDegrees1 = (angleRadians1 * 180) / Math.PI;
	const angle1 = angleDegrees1.toFixed(3);

	const angleRadians2 = Math.atan2(-dataJ2[1], dataJ2[0]);
	const angleDegrees2 = (angleRadians2 * 180) / Math.PI;
	const angle2 = angleDegrees2.toFixed(3);

	//var dataY = JSON.stringify(joystick2.value);
    if (isLocked){
        document.getElementById("x1").textContent = dataJ2[0];
        document.getElementById("y1").textContent = dataJ2[1];
        document.getElementById("angle1").textContent = angle2;
		axeX = dataJ2[0];
		axeY = dataJ2[1];
		angle = angle2;
    } else {
        document.getElementById("x1").textContent = dataJ1[0];
        document.getElementById("y1").textContent = dataJ1[1];
        document.getElementById("angle1").textContent = angle1;
		axeX = dataJ1[0];
		axeY = dataJ1[1];
		angle = angle1;
    }



	//document.getElementById("status2").textContent = dataY[0];

}

function loop()
{
	requestAnimationFrame(loop);
	update();
}

loop();

