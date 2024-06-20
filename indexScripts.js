let image = document.querySelectorAll(".images_displayed img");


console.log(index);
console.log(index % 2);
for (let i = 0; i < image.length; i++){
	(function(i) {
		image[i].addEventListener("click", function() {
			document.querySelector(".chosen_image").style.opacity = '1';
			document.querySelector(".chosen_image").style.zIndex = '2';
			document.querySelector(".chosen_image img").src = image[i].getAttribute("src");
			document.querySelector(".image_info h1").innerHTML = JSON.stringify(name[i + index]).replace(/\"/g, "");
			document.querySelector("#doc").innerHTML = JSON.stringify(doc[i + index]).replace(/\"/g, "");
			document.querySelector("#width").innerHTML = JSON.stringify(width[i + index]).replace(/\"/g, "");
			document.querySelector("#height").innerHTML = JSON.stringify(height[i + index]).replace(/\"/g, "");
			document.querySelector("#price").innerHTML = JSON.stringify(price[i + index]).replace(/\"/g, "");
			document.querySelector("#desc").innerHTML = JSON.stringify(desc[i + index]).replace(/\"/g, "");


			document.querySelector("input[name='image']").value = image[i].getAttribute("src");
			document.querySelector("input[name='image_name']").value = JSON.stringify(name[i + index]).replace(/\"/g, "");
			document.querySelector("input[name='doc']").value = JSON.stringify(doc[i + index]).replace(/\"/g, "");
			document.querySelector("input[name='width']").value = JSON.stringify(width[i + index]).replace(/\"/g, "");
			document.querySelector("input[name='height']").value = JSON.stringify(height[i + index]).replace(/\"/g, "");
			document.querySelector("input[name='price']").value = JSON.stringify(price[i + index]).replace(/\"/g, "");
			document.querySelector("input[name='desc']").value = JSON.stringify(desc[i + index]).replace(/\"/g, "");

		})
	})(i);
}

function close_image(){
	document.querySelector(".chosen_image").style.opacity = '0';
	document.querySelector(".chosen_image").style.zIndex = '-1';
}

window.onscroll = function() {myFunction()};

function myFunction() {
	if (document.documentElement.scrollTop > 1) {
		document.getElementById("Nav").style.width = "15vw";
	} else {
		document.getElementById("Nav").style.width = "50vw";
	}
}