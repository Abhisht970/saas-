import idleTimeout from 'idle-timeout';

const csrfToken = document.querySelector(
    'meta[name="csrf-token"]'
)?.content;

let wasIdle = false;

async function sendActivityEvent(url) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
        });

        const result = await response.json();
        console.log('Activity tracking:', result);
    } catch (error) {
        console.error('Activity tracking error:', error);
    }
}

const inactivityTimer = idleTimeout(
    () => {
        wasIdle = true;
        console.log('User is idle');

        sendActivityEvent('/activity/idle');
    },
    {
        element: document,
        timeout: 3 * 1000,
        loop: false,
    }
);

function handleActivity() {
    if (wasIdle) {
        wasIdle = false;

        console.log('User is active again');
        sendActivityEvent('/activity/active');
    }

    inactivityTimer.reset();
}

document.addEventListener('mousemove', handleActivity);
document.addEventListener('keydown', handleActivity);
document.addEventListener('mousedown', handleActivity);
document.addEventListener('touchstart', handleActivity);
document.addEventListener('scroll', handleActivity);