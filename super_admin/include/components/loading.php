<style>
        
        .loader{
    width: 100px;
    height: 100px;
    margin: 30px;
    border-radius: 50%;
    background-color: rgb(0, 13, 24);
    box-shadow: inset 7px 7px 25px 0 rgba(0, 0, 0,.5),
                inset -7px -7px 25px 0 rgba(205, 255, 185, 0.384);
    position: relative;
    
}
.loader::before{
    content: "";
    /* margin: 30px; */
    width: 80px;
    height: 80px;
    background-color: rgb(0, 13, 24);
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    box-shadow: 7px 7px 25px 0 rgba(0, 0, 0,.3),
                -7px -7px 25px 0 rgba(205, 255, 185, 0.384); 
    z-index: 1;
    /* opacity: 1; */
}
.loader::after{
    content: "";
    width: 70px;
    height: 70px;
    /* background-color: red; */
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    animation: rotate .3s infinite linear;
    box-shadow: 0px 0px 2px rgba(0, 255, 0, 0.5),
        0px 0px 9px rgba(0, 255, 0, 0.5),
        0px 0px 18px rgba(0, 255, 0, 0.5);
}
@keyframes rotate {
    0%{
        transform: translate(-50%,-50%) rotate(0deg);
    }100%{
        transform: translate(-50%,-50%) rotate(360deg);
    }
}
.li::after{
    
    border: 30px solid lime;
    border-right: solid 30px transparent;
    border-top: solid 30px transparent;
    border-left: solid 30px transparent;
    z-index: 9999;
    
}
.coo{
    position: fixed;
    /* transform: translateY(30%); */
    width: 100%;
    min-height: 100vh;
    background-color: rgb(0, 13, 24);
    height: 400px;
    display: flex;
    z-index: 9999;
    align-items: center;
    justify-content: center;
    border: 1px solid lime;
    opacity: .5;
    display:flex;
    transition: 1s;
}
@keyframes fade {
    100%{
        opacity: 1;
    }0%{
        opacity: 0;
        display: none;

    }
}
.finished{
    animation: fade .3s ease-out;
    /* transition: 1s; */
    display: none;
}
</style>
<div class="coo ">
	<div class="loader li">
	</div>
</div>