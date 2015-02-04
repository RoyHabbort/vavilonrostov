

angular.module('app', ['ngRoute'])
    
        /*
         * 3-12-2014
         * Фабрика для работы с номерами
         * roy
         */
    
        .factory('Appartment', function($http, $q){
            var result = {
                alarm:function(){
                    alert('alarm!!!');
                },
                getAllAppartaments:function($scope){
                    $http.get('/ajax/getAllAppartaments')
                    .then(function(resp){
                        if(resp.data.errors){
                            result.errors(resp.data.errors);
                            return false;
                        }
                        if(resp.data.success){
                            $scope.listAppartaments =  resp.data.appartaments;
                            $scope.changeApparament = $scope.listAppartaments[0];
                            result.changedAppartment($scope, $scope.listAppartaments[0]);
                        }else{
                            result.errors('Извините. Произошла непредвиденная ошибка. Попробуйте перезагрузить страницу');
                        }
                                
                    }, function(err){
                        result.errors('Ошибка связи с сервером. Попробуйте обновить страницу');
                    });  
                },
                changedAppartment:function($scope, changeAppartment){
                    
                    console.log(changeAppartment);
                    $scope.sliderAppartament = changeAppartment.slider_appartament;
                    setTimeout(function(){

                        if(HERETIC.modules.sliderApi.mainSlider.API){
                            HERETIC.modules.sliderApi.mainSlider.reload();
                        }else{
                            HERETIC.modules.sliderApi.mainSlider.initiate();  
                        }

                    }, 100);
                    
                },
                errors:function(err){
                    if(err){
                        alert(err);
                    }else{
                        alert('Ошибка модели бронирования');
                    }
                }
            };
            return result;
    })


    /*
     * 3-12-2014
     * Фабрика работы с заказом Конгресс Хола
     * roy
     */

    .factory('Order', function($http, $q){
        var result = {
            test:function(){
                alert('alarm!!!');
            },
            sendOrder:function($scope, kongressOrder){
                console.log(kongressOrder);
                var perErrors = {},
                    err = {};
                
                
                if(!kongressOrder.date){
                    perErrors.date = 'Данное поле обязательно для заполнения';
                }
                if(!kongressOrder.time){
                    perErrors.time = 'Данное поле обязательно для заполнения';
                }
                if(!kongressOrder.duration){
                    perErrors.duration = 'Данное поле обязательно для заполнения';
                }
                if(!kongressOrder.phone){
                    perErrors.phone = 'Данное поле обязательно для заполнения';
                }
                
                if(perErrors){
                    
                    err = {
                        'errors' : 'Форма заполнена неверно',
                        'valid_errors' : perErrors
                    };
                    
                    result.errors(err, $scope)
                    
                }else{
                    $http.post('/ajax/sendOrder', {'data' : kongressOrder})
                    .then(function(resp){
                            
                        if(resp.data.errors){
                            result.errors(resp.data.errors, $scope);
                            return false;
                        }
                        if(resp.data.success){
                            console.log(resp.data);
                        }else{
                            result.errors('Извините. Произошла непредвиденная ошибка. Попробуйте перезагрузить страницу', $scope);
                        }
                            
                    }, function(err){
                        result.errors('', $scope)
                    })
                }
                
            },
            errors:function(err, $scope){
                if(err){
                    
                    if(err.valid_errors){
                        $scope.errorOrder = err.valid_errors;
                        err = err.errors;
                    }
                    
                    alert(err);
                }else{
                    alert('Ошибка модели бронирования');
                }
            }
        }

        return result;
        
    })

        /*
         * 3-12-2014
         * Контроллер работы с бронированием
         * roy
         */


        .controller('bookingCtrl', function($scope, $http, Appartment){
            
            $(document).ready(function(){
                Appartment.getAllAppartaments($scope);
                $scope.changedAppartmentC = function(changeAppartment){
                    Appartment.changedAppartment($scope, changeAppartment);
                }
            });
        
    })
    
        /*
         * 3-12-2014
         * Контроллер работы с конгресс холом
         * roy
         */
    
        .controller('kongressCtrl', function($scope, $http, Order){

        $scope.kongressOrder = {
            duration : 1
        };
        
        $(document).ready(function(){
           
            $scope.errorOrder = '';
            $scope.sendOrder = function(kongressOrder){
                Order.sendOrder($scope, kongressOrder);
            }
            
        });
        
    });