window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });


// window.Echo = new Echo({
//     broadcaster: "pusher",
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     // authEndpoint: process.env.MIX_ECHO_AUTH_ENDPOINT, // we are using custom method to authenticate user
//     // wsHost: process.env.MIX_PUSHER_WSHOST,
//     wsPort: process.env.MIX_PUSHER_WSPORT,
//     wssPort: process.env.MIX_PUSHER_WSSPORT,
//     // forceTLS: false,
//     enabledTransports: ['ws', 'wss'],
//     disableStats: true,
//     authorizer: (channel) => {
//       return {
//         authorize: (socketId, callback) => {
//           fetch(process.env.MIX_ECHO_AUTH_ENDPOINT, {
//             method: "POST",
//             headers: {
//               "Content-Type": "application/json",
//               Authorization: "Bearer " + localStorage.getItem("token"),
//             },
//             body: JSON.stringify({
//               socket_id: socketId,
//               channel_name: channel.name,
//             }),
//           })
//             .then((response) => response.json())
//             .then((data) => {
//               callback(false, data);
//             })
//             .catch((error) => {
//               callback(true, error);
//             });
//         },
//       };
//     },
//   });


window.Echo = new Echo({
  broadcaster: 'pusher',
  key: process.env.MIX_PUSHER_APP_KEY,
  cluster: process.env.MIX_PUSHER_APP_CLUSTER,
  encrypted: true
});