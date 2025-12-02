particlesJS("particles-js", {
  "particles": {
    "number": { "value": 40 },
    "color": { "value": "#ffffff" },
    "shape": { "type": "circle" },
    "opacity": { "value": 0.5 },
    "size": { "value": 2 },
    "line_linked": {
      "enable": true,
      "distance": 150,
      "color": "#ffffff",
      "opacity": 0.4,
      "width": 2
    },
    "move": {
      "enable": true,
      "speed": 5
    }
  },
  "interactivity": {
    "detect_on": "canvas", 
    "events": {
      "onhover": {
        "enable": true,
        "mode": "repulse" 
      },
      "onclick": {
        "enable": false
      }
    },
    "modes": {
      "repulse": {
        "distance": 50, 
        "duration": 0.4
      }
    }
  }
});
