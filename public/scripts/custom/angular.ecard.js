

angular.module('ecard.gallery', [])

    .factory("ecardGallery",["$http",
        function($http){
            var fac = {};

            fac.viewData = function(page){
                //console.log(page);
                return $http.get("ecard-gallery-view?page="+page);
            };
            fac.searchData = function(txt){
                return $http.get("ecard-gallery-search/"+txt);
            }
            fac.selectpicData = function(id){
                return $http.get("ecard-gallery-select/"+id);
            }


            return fac;
        }])

    .controller("ecard-gallery",["$scope","$window","ecardGallery",
        function($scope,$window,ecardGallery){
            $scope.controllerName = 'ecard-gallery' ;
            $scope.data = [];
            $scope.sts_selectpic = false ;
            $scope.gallery_image_page = 1 ;
            //---- pagination
            $scope.totalPages = 0;
            $scope.currentPage = 1;
            $scope.range = [];
            $scope.getPosts = function(pageNumber){
                if(pageNumber===undefined||pageNumber==0){
                    pageNumber = '1';
                }
                ecardGallery.viewData(pageNumber).success(function(result){ // ดึงข้อมูลสำเร็จ ส่งกลับมา
                    $scope.data = result.data;
                    $scope.totalPages   = result.last_page;
                    $scope.currentPage  = result.current_page;
                    $scope.gallery_image_page = pageNumber ;
                    // Pagination Range
                    var pages = [];
                    for(var i=1;i<=result.last_page;i++) {
                        pages.push(i);
                    }
                    $scope.range = pages;
                });
            };
            $scope.getPosts();
            //---- end pagination

            //$scope.$emit('LOAD')
            //setTimeout( $scope.$emit('UNLOAD')
            //   ,
            //    ( 5 * 1000 )
            //);
            //
            //$scope.$on('LOAD',function(){$scope.loading=true});
            //$scope.$on('UNLOAD',function(){$scope.loading=false});

            $scope.close_search = function(){
                getPosts(1);
                $scope.sts_selectpic = false ;
            }
            $scope.close_search=function(){
                $scope.getPosts(1);
                $scope.sts_selectpic = false ;
            }
            $scope.complete=function(){
                var txt = $scope.search_name;
                $scope.autocomplete = true ;
                $scope.sts_selectpic = true ;
                ecardGallery.searchData(txt).success(function(result){
                    $scope.searchs = result;
                });
            }
            $scope.selectpic = function(id){
                $scope.data = [] ;
                ecardGallery.selectpicData(id).success(function(result){
                    $scope.data = result;
                    $scope.autocomplete = false ;
                });
            }


        }])