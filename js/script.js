import { OrbitControls } from "https://threejs.org/examples/jsm/controls/OrbitControls.js";

// renderer
var renderer = new THREE.WebGLRenderer();
renderer.setSize( window.innerWidth, window.innerHeight);
document.body.appendChild( renderer.domElement );

// scene
var scene = new THREE.Scene();

// camera
var camera = new THREE.PerspectiveCamera( 60, window.innerWidth/ window.innerHeight, 0.1, 1000);
camera.position.z = 5;

// controls
var controls = new OrbitControls(camera, renderer.domElement);

// geometry & mesh
var geometry = new THREE.BoxGeometry( 1, 1, 1);
var material = new THREE.MeshPhongMaterial( {color: "#3b5998"} );
var cube = new THREE.Mesh( geometry, material );
scene.add(cube);


// ambient
var ambientLight = new THREE.AmbientLight(0xFFFFFF, 2);
scene.add(ambientLight);

// light
var directionalLight = new THREE.DirectionalLight(0xFFFFFF, 4);
directionalLight.position.set(1,1,0);
scene.add(directionalLight);

function animate() {
    requestAnimationFrame( animate );
    // cube.rotation.x += 0.01;
    cube.rotation.y += 0.01;
    renderer.render (scene, camera);
}

animate();