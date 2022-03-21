<template>
<section class="services" id="services">

    <h1 class="headings">teikiamos <span>procedūros</span></h1>

    <div class ="box-container">

        <div class ="box">
            <h3>Kanalo plombavimas</h3>
            <p>
                plombavimas, atliekamas naudojant dentalinį „Carl Zeiss“ OPMI pico markės mikroskopą. 
                Pasitelkiant mikroskopą galima pamatyti tai, ko neįmanoma pamatyti plika akimi: siauras kanalų įeigas, 
                papildomus kanalus, dantų šaknų skilimus ar traumos pasėkoje kalcifikuotus kanalus.
            </p>
            <div class = "cost">Kaina: 20 eurų</div>
            <!--<a href="#" class="btn"> learn more <span class="fas fa-chevron-right"></span></a>-->
        </div>    
    </div>
   
</section>
    
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style>
.headings{
    text-align: center;
    padding-bottom: 2rem;
    text-transform: uppercase;
    color: var(--black);
    font-size: 5rem;
    padding-top: 10rem;
    letter-spacing: .4rem;
}
.headings span{
    text-transform: uppercase;
    color: var(--green);
    font-size: 5rem;
    letter-spacing: .4rem;
}

.services .box-container{
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(43rem, 1fr));
    gap: 2rem;
}

.services .box-container .box{
    background: #fff;
    border-radius:  .5rem;
    box-shadow: var(--box-shadow);
    border: var(--border);
    padding: 2.5rem;
}


.services .box-container .box i{
    color: var(--green);
    font-size: 5rem;
    padding-bottom: .5rem;
}

.services .box-container .box h3{
    color: var(--black);
    font-size: 2.5rem;
    padding: 1rem 0;
    text-transform: none;
    color: var(--green);
}

.services .box-container .box p{
    color: var(--light-color);
    font-size: 1.4rem;
    line-height: 2;
    text-transform: none;
}
.services .cost{
    color: var(--green);
    text-transform: none;
    font-size: 1.5rem;
    font-weight: bold;
    text-align: right;
}
</style>