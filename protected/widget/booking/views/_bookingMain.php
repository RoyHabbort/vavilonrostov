<div class="booking-widget">
    
    <div class="booking-menu">
        <div class="booking-apartament">
            <div class="booking-apartament-text">Бронировать номер</div>
            <!--div class="booking-apartament-icon"></div -->
            <div class="clearfix"></div>
        </div>
        <div class="booking-table">
            <div class="booking-table-icon"></div>
            <div class="booking-table-text">Заказать столик</div>
            <div class="clearfix"></div>
        </div>    
    </div>
    
    <div class="booking-section booking-apartament-section">
        
        <div class="form-row input-row">
            <label>Дата въезда в отель</label>
            <input type="text" name="" class="date-input">
            <div class="calendar-icon"></div>
        </div>    
        
        <div class="form-row input-row">
            <label>Дата отъезда из отеля</label>
            <input type="text" name="" class="date-input">
            <div class="calendar-icon"></div>
        </div>
        
        <div class="form-row multi-form-row input-row">
            <div class="form-cell">
                <label>Номера</label>
                <div class="arif-arrow">
                    <select class="select-clear" type="text" name="appartaments" ng-change="changedAppartmentC(changeApparament)" ng-model="changeApparament" ng-options="listAppartament.title for listAppartament in listAppartaments">
                    </select>
                </div>
            </div>
        </div>
        
        <div class="btn-row input-row">
            <div class="btn btn-green">Заказать</div>  
            <div class="btn-separate"></div>
            <a href="/selectAppartament" class="btn btn-blue">Подбор номера</a>  
        </div>
        
        <!--div class="help-text">
            <a href="/">Программы скидок</a>
        </div-->  
        
    </div>  
    
    <div class="booking-section booking-restoraunt-section">
        
        <div class="form-row input-row">
            <label>Дата</label>
            <input type="text" name="" class="date-input">
            <div class="calendar-icon"></div>
        </div>  
        
        <div class="form-row multi-form-row input-row">
            <div class="form-cell">
                <label>Время</label>
                <div class="arif-arrow">
                    <input type="text" name="" class="spinner">
                    <div class="arif-arrow-up">▲</div>
                    <div class="arif-arrow-down">▼</div>
                </div>
            </div>
            <div class="form-cell">
                <label>Кол-во гостей</label>
                <div class="arif-arrow">
                    <input type="text" name="" class="spinner">
                    <div class="arif-arrow-up">▲</div>
                    <div class="arif-arrow-down">▼</div>
                </div>    
            </div>
        </div>
        
        <div class="form-row input-row">
            <label>Дополнительная информация</label>
            <textarea class=""></textarea>
        </div>  
        
        
        <div class="btn-row">
            <div class="btn btn-green">Заказать</div>  
            <div class="btn-separate"></div>
            <a href="/" class="btn btn-red">Посмотреть цены</a>  
        </div>
          
    </div> 
    
</div>    