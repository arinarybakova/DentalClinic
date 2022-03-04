<section class="book" id = "book"> 
    <h1 class="heading"><span>book</span> now </h1>

    <div class="row">

        <div class="image">
            <img src = "../assets/images/book-img.svg" alt="">
        </div>

        <form action="">
            <h3>book appointment</h3>
            <input type="text" placeholder="your name" class="box">
            <input type="email" placeholder="your email address" class="box">
            <input type="number" placeholder="your number" class="box">
            <input type="date"  class="box">
            <label for="doctors">Pasirinkite gydytoją:</label>
            <select name="doctors" id="doctors">
            <optgroup label="Gydytojai">
                <option value="periodontologas">Periodontologas</option>
                <option value="odontologas">Odontologas</option>
                <option value="endodontologas">Endodontologas</option>
                <option value="burnos chirurgas">Burnos chirurgas</option>
                <option value="higienistas">Higienistas</option>
            </optgroup>
            </select>
            <input type="submit" value="book now" class="btn">
        </form>

    </div>
</section>