
class MainComponent extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            status: 'ORDERED',
            defaultComponent: 'DISPATCHER-LIST',
            request: []
        };
    }

    handleUpdateStatus = (status, defaultComponent) => {
        this.setState({
            status:status,
            defaultComponent: defaultComponent
        });
    }

    

    render() {
        
        let defaultComponent = null;

        if(this.state.defaultComponent == "DISPATCHER-LIST") {
            defaultComponent =  <DispatcherListComponent status={this.state.status} assignProvider={this.handleProvider }  />;
        } else if(this.state.defaultComponent == "ASSIGNED-LIST") {
            defaultComponent =  <AssignedListComponent status={this.state.status}  />;
        }  

        return (<div>
                    <div className="tabs">
                        <div className="tab-button-outer">
                            <ul id="tab-button">
                                <li className={this.state.status == "ORDERED" ? "is-active" : "" } onClick={this.handleUpdateStatus.bind(this, 'ORDERED', 'DISPATCHER-LIST')}><a><i className="fa fa-search"></i> Incoming Orders</a></li>
                                <li className={this.state.status == "ACCEPTED" ? "is-active" : "" } onClick={this.handleUpdateStatus.bind(this, 'ACCEPTED', 'ASSIGNED-LIST')}><a><i className="fa fa-check"></i> Accepted Orders</a></li>
                            </ul>
                        </div> 
                    </div> 
                    {
                        defaultComponent
                    }
                </div>);
    }
}

class DispatcherListComponent extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            requests: [],
            orderlist: [],
            accept:{
                    cooking_time:'',
                    store_order_id:'',
                    delivery_date_time:'',
                   },
            errors: {},
        };
    }

    validate = () => {
        const errors = {};
        const accept = this.state.accept;
        if(accept.store_type=='FOOD'){
            if(accept.cooking_time.trim() === '')
                errors.cooking_time = 'Cooking Time is required';
        }else{
            if(accept.delivery_date_time.trim() === '') {
                const accept = {...this.state.accept};
                accept['delivery_date_time'] = $('#delivery_date_time').val();
                this.setState({accept}, () => {
                    if(accept.delivery_date_time.trim() === '') errors.delivery_date_time = 'Date/Time is required';  
                });
            }
            
        }    
        return Object.keys(errors).length === 0 ? null : errors;
    }

    handleChange = ({currentTarget: input}) => {

        const errors = { ...this.state.errors };
        const accept = {...this.state.accept};

        if(input.value.trim() !== '' ) {
            delete errors[input.name];
        }
        
        accept[input.name] = input.value;
        this.setState({accept, errors});
    }

    handleSubmit = e => {
        e.preventDefault();

        const errors = this.validate();
        this.setState({errors: errors || {} });

        if(errors) return;
        $.ajax({
            url: getBaseUrl() + "/shop/dispatcher/accept",
            type: "post",
            headers: {
                Authorization: "Bearer " + getToken("shop")
            },
            data: {
                store_order_id: $('input[name=id]').val(),
                cooking_time: $('input[name=cooking_time]').val(),
                delivery_date: $('input[name=delivery_date_time]').val(),
            },
            success: (response, textStatus, jqXHR) => {
                alertMessage(textStatus, jqXHR.responseJSON.message, "success");
                setTimeout(function(){location.reload();}.bind(this),1000);
            }, error: (jqXHR, textStatus, errorThrown) => {
                alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
            }
        });
    }


    handleCourierOrderSubmit(request, e) {
        e.preventDefault();

        let store_order_id = request.id;
        let store_type_id = request.store_type_id
        let store_id = request.store_id
        let user_id = request.user_id

        const errors = this.validate();
        this.setState({errors: errors || {} });

        if(errors) return;
        $.ajax({
            url: getBaseUrl() + "/shop/dispatcher/accept",
            type: "post",
            headers: {
                Authorization: "Bearer " + getToken("shop")
            },
            data: {
                store_order_id: store_order_id,
                store_type_id: store_type_id,
                store_id: store_id,
                user_id: user_id
            },
            success: (response, textStatus, jqXHR) => {
                alertMessage(textStatus, jqXHR.responseJSON.message, "success");
                setTimeout(function(){location.reload();}.bind(this),1000);
            }, error: (jqXHR, textStatus, errorThrown) => {
                alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
            }
        });
    }

    componentDidMount() {
        this.getStatus();
        //window.polling = setInterval(() => this.getStatus(), 1000);
        var that = this;
        var socket = io.connect(window.socket_url);
        socket.emit('joinShopRoom', `room_${window.room}_shop_${window.shop_id}`); 
        socket.off().on('newRequest', function (data) {
            that.getStatus();
        });

        
    }

    componentWillUnmount() {
        //clearInterval(window.polling);
    }

    handleClick(request, e) {
        if(request.request.request_type == "MANUAL") {
            this.props.assignProvider(request);
        } else {
            alertMessage("Error", "Auto assigned requests cannot be assigned", "danger");
        }
        
    } 
    
    handleOrderlist(request, e) {
        e.stopPropagation();
        this.setState({
            orderlist: request,
            accept: {
                  ...this.state.accept,
                  store_order_id: request.id,
                  store_type:request.pickup.storetype.category
            }
        });
    }
    handleOrderCancel(request, e) {
        e.stopPropagation();
        this.setState({
            orderCancel: request
        });
    }
    handleAccept(request, e) {
        e.stopPropagation();
       this.setState({
            accept: {
                  ...this.state.accept,
                  store_order_id: request.id,
                  store_type:request.pickup.storetype.category
            }
        });
    }

    handleAcceptreset = e => {
        e.stopPropagation();
        this.setState({
            accept: {
                  ...this.state.accept,
                  cooking_time: "",
                  
            }
        });
        
    }

    handleCancel= e => {
        e.preventDefault();

        const errors = this.validate();
        this.setState({errors: errors || {} });

        if(errors) return;

          $.ajax({
                url: getBaseUrl() + "/shop/dispatcher/cancel",
                type: "post",
                headers: {
                    Authorization: "Bearer " + getToken("shop")
                },
                'beforeSend': function (request) {
                    showLoader();
                },
                data: {
                    id:  $('input[name=id]').val(),
                    store_id: $('input[name=store_id]').val(),
                    user_id: $('input[name=user_id]').val(),
                    cancel_reason: $('#cancel_reason').val(),
                },
                success: (response, textStatus, jqXHR) => {
                alertMessage(textStatus, jqXHR.responseJSON.message, "success");
                setTimeout(function(){location.reload();}.bind(this),1000);
                }, error: (jqXHR, textStatus, errorThrown) => {}
            });
       
    }

    getStatus() {
                
        let url = getBaseUrl() + "/shop/dispatcher/orders?type="+this.props.status;
        if (getShopDetails().store_type_id == 6) {
            url = getBaseUrl() + "/shop/dispatcher/products?type="+this.props.status;
        }
        $.ajax({
            url: url,
            type: "get",
            processData: false,
            contentType: false,
            headers: {
                Authorization: "Bearer " + getToken("shop")
            },
            success: (response, textStatus, jqXHR) => {
                var data = parseData(response);

                if(data.responseData.length > 0) {
                    // if(data.responseData[0].status == 'ORDERED') {
                    //     var media = document.getElementById("beep-one");
                    //     const playPromise = media.play();
                    //     if (playPromise !== null){
                    //         playPromise.catch(() => { media.play(); })
                    //     }
                    // }
                }
                
              
                this.setState({
                    requests: (data.responseData.length > 0) ? data.responseData : [],
                });
            }, error: (jqXHR, textStatus, errorThrown) => {}
        });
    }

    render() {

        let requests = this.state.requests;
        let invoice=(this.state.orderlist.length != 0)? this.state.orderlist.invoice.items : [];
        let {accept, errors } = this.state;
        return (
                    <div className="tab-contents row">
                   
                        <div className="col-md-12 p-0 bg-body">
                            <div className="tab_sub_title">
                                <h6 className="m-0">Searching List</h6>
                            </div>

                            <div className="tab_body fnt_weight_400">

                            {requests.map((request) =>
                                <div key={request.id} onClick={ this.handleClick.bind(this, request) } className="bg-white m-lr-20 shadow-sm">
                                     <a className="btn btn-sm btn-green float-right m-2">{request.status}</a>
                                    <div className="p-2">
                                        <p className="font_16 txt_clr_2 fnt_weight_500">{request.user.first_name} {request.user.last_name}</p>
                                        <p className="font_14">Booking ID: {request.store_order_invoice_id}</p>
                                        <p className="font_14">Number: {request.user.mobile}</p>
                                        <a className=" m-2 c-pointer btn btn-blue "  onClick={ this.handleOrderlist.bind(this, request) } data-toggle="modal" data-target="#order-list">Order List</a>
                                        <span>
                                        {
                                            getShopDetails().store_type_id != 6 
                                                ?
                                                <a className=" m-2 c-pointer btn btn-green"  onClick={ this.handleAccept.bind(this, request) } data-toggle="modal" data-target="#accept">Accept</a> 
                                                :
                                                <a className=" m-2 c-pointer btn btn-green"  onClick={ this.handleCourierOrderSubmit.bind(this, request) } >Accept</a> 
                                        }
                                        <a className=" m-2 c-pointer btn btn-red" onClick={ this.handleOrderCancel.bind(this, request) }  data-toggle="modal" data-target="#cancelModal">Cancel <i className="material-icons">cancel</i></a>
                                        </span>
                                    </div>
                                </div>
                                )
                            }
                         </div>
                      </div>

                        

                        <div id="accept" className="modal fade" role="dialog">
                            <div className="modal-dialog ">
                                <div className="modal-content">
                                   <div className="modal-header">
                                        <h4 className="modal-title">Preparation Time</h4>
                                    </div>
                                    <div className="modal-body">
                                        <form onSubmit={this.handleSubmit} id="form-create-ride">
                                            <div className="form-row mb-3">
                                                <div className="form-group col-md-6">
                                                    {(() => {
                                                        switch(accept.store_type) {
                                                            case 'FOOD':  
                                                                return <div>
                                                                            <label htmlFor="first_name">Cooking Time (Minutes) </label> 
                                                                            <input type="hidden" className="form-control" id="store_order_id"  name="id"  value={accept.store_order_id}  />
                                                                            <input type="number" className="form-control" id="order_ready_time" placeholder="Cooking Time" name="cooking_time" onChange={this.handleChange} value={accept.cooking_time}  />
                                                                            {errors && <div className="text-danger">{errors.cooking_time}</div>}
                                                                      </div>
                                                            case 'OTHERS':
                                                                setTimeout(() => {
                                                                    $('#delivery_date_time').datetimepicker({
                                                                        format:'YYYY-MM-DD HH:mm:ss',
                                                                        defaultDate:new Date(),
                                                                    });
                                                                }, 100);

                                                                return <div>
                                                                    <label htmlFor="first_name">Delivery Date/Time  </label> <input type="hidden" className="form-control" id="store_order_id"  name="id"  value={accept.store_order_id}  /><input type="text" className="form-control" id="delivery_date_time"  name="delivery_date_time" onChange={this.handleChange} value={accept.delivery_date_time}  />
                                                                    {errors && <div className="text-danger">{errors.delivery_date_time}</div>}
                                                                </div>
                                                        }  
                                                     })()}
                                                </div>
                                            </div>
                                            <br />
                                            <button type="reset" onClick={ this.handleAcceptreset } className="btn btn-danger" data-dismiss="modal">Cancel</button>
                                            <button type="submit" className="btn btn-accent float-right">Submit</button>
                                        </form>
                                    </div>
                                </div> 
                            </div>
                       </div>

                        <div id="order-list" className="modal fade" role="dialog">
                            <div className="modal-dialog modal-lg">
                                <div className="modal-content">
                                    <div className="modal-header">
                                    <h4 className="modal-title">Order List</h4>
                                    </div>
                                    <div className="modal-body">
                                    <div className="form-row mb-3">
                                            <div className="form-group col-md-4">
                                                <label htmlFor="first_name" className="font-weight-bold">Order ID : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.store_order_invoice_id : ""}</b></span>
                                            </div>
                                            <div className="form-group col-md-4">
                                                <label htmlFor="last_name" className="font-weight-bold" >SHOP Name : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.pickup.store_name : ""}</b></span>
                                            </div>
                                            <div className="form-group col-md-4">
                                                <label htmlFor="last_name" className="font-weight-bold" >Customer Name : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.user.first_name : ""}</b></span>
                                            </div>
                                        </div>
                                        <div className="form-row mb-3">
                                            <div className="form-group col-md-4">
                                                <label htmlFor="first_name" className="font-weight-bold" >Delivery Address : </label><span><b>{(this.state.orderlist.length != 0 && this.state.orderlist.delivery)? this.state.orderlist.delivery.map_address : ""}</b></span>
                                            </div>
                                            <div className="form-group col-md-4">
                                                <label htmlFor="last_name" className="font-weight-bold" >Phone Number : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.user.mobile : ""}</b></span>
                                            </div>
                                            <div className="form-group col-md-4">
                                            {(accept && accept.store_type  == "OTHERS")? 
                                                <div>
                                                <label htmlFor="last_name" className="font-weight-bold" >Delivery Date : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.delivery_time : ""}</b></span>
                                            </div>
                                           :''}
                                            </div>
                                        </div> 
                                        <div className="form-row mb-3">
                                            <div className="form-group col-md-4">
                                                <label htmlFor="first_name" className="font-weight-bold" >Note : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.note : ""}</b></span>
                                            </div>
                                            <div className="form-group col-md-4">
                                                <label htmlFor="last_name" className="font-weight-bold" >Total Amount : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.currency+''+this.state.orderlist.invoice.total_amount : ""}</b></span>
                                            </div>
                                            <div className="form-group col-md-4">
                                                <label htmlFor="last_name" className="font-weight-bold">Status : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.status : ""}</b></span>
                                            </div>
                                        </div>
                                       <table className="table table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Sno</th>
                                                <th>Product Name</th>
                                                <th>Note</th>
                                                <th>Price</th>
                                                <th>Unit</th>
                                                <th>Quantity</th>
                                                <th>Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        {invoice.map((item,i) =>
                                              
                                            <tr key={i}>
                                                <td>{i+1}</td>
                                                <td>
                                                {item.product.item_name}
                                                {(() => {
                                                    
                                                    let addonList=item.cartaddon;
                                                   return <div key={i+"key"}>{addonList.map((addon,j) =>
                                                        <div key={j+"key"}><small>Addon : {addon.addon_name}({this.state.orderlist.currency}{addon.addon_price})</small></div>
                                                    )}</div>
                                                   
                                                })()}
                                                </td>
                                                <td>{item.note}</td>
                                                <td>{(this.state.orderlist.currency)? this.state.orderlist.currency : "$"}{item.item_price}</td>
                                                <td>{item.item_quantity} {item.unit}</td>
                                                <td>{item.quantity}</td>
                                                <td>{(this.state.orderlist.currency)? this.state.orderlist.currency : "$"}{item.total_item_price}</td>
                                            </tr>
                                          
                                           
                                            
                                        )}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Discount</th>
                                                <th><span>: </span><b>{(this.state.orderlist.length != 0) ? this.state.orderlist.currency + this.state.orderlist.invoice.discount : ""}</b></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Delivery Charge</th>
                                                <th><span>: </span> <b>{(this.state.orderlist.length != 0) ? (this.state.orderlist.currency) + (this.state.orderlist.invoice.delivery_amount) : ""}</b></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Shop Package Charge</th>
                                                <th><span>: </span><b>{(this.state.orderlist.length != 0)? (this.state.orderlist.currency) + this.state.orderlist.invoice.store_package_amount : ""}</b></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Shipping & Handling</th>
                                                <th><span>: </span> <b>{(this.state.orderlist.length != 0)? (this.state.orderlist.currency) + "0.00" : ""}</b></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>GST</th>
                                                <th><span>: </span> <b>{(this.state.orderlist.length != 0)? (this.state.orderlist.currency) + this.state.orderlist.invoice.tax_amount : ""}</b></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Total</th>
                                                <th><span>: </span> {(this.state.orderlist.length != 0)? (this.state.orderlist.currency) + this.state.orderlist.invoice.total_amount : ""}</th>
                                            </tr>
                                        </tfoot>


                                        </table>
                                   </div>
                                   <div className="modal-footer">
                                     <a className=" m-2 c-pointer btn btn-red "  data-dismiss="modal">Close</a>
                                  </div>
                                </div>
                            </div>
                        </div>



                         <div className="modal" id="cancelModal">
                   <div className="modal-dialog">
                      <div className="modal-content">
                         <div className="modal-header">
                            <h4 className="modal-title">Reason For Cancellation</h4>
                            <button type="button" className="close" data-dismiss="modal">&times;</button>
                         </div>
                           <form onSubmit={this.handleCancel} id="form-create-ride">
                         <div className="modal-body">
                            <div className="comments-section field-box" id ="cancel_comments">
                               <h5 className=" no-padding"><strong>Tell us why you are cancelling the order</strong></h5>
                               <textarea className="form-control" rows="4" cols="50" id="cancel_reason" name="cancel_reason"></textarea>
                            </div>
                            {this.state.orderCancel &&
                             (<React.Fragment><input type="hidden" name="id" value={this.state.orderCancel.id}  />
                              <input type="hidden" name="store_id" value={this.state.orderCancel.store_id}  />
                               <input type="hidden" name="user_id" value={this.state.orderCancel.user.id}  /></React.Fragment>)
                           }
                         </div>
                         <div className="modal-footer">
                         <button type="reset" onClick={ this.handleAcceptreset } className="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" className="btn btn-accent float-right">Submit</button>
                         </div>
                         </form>
                      </div>
                   </div>
                </div>
                    </div>

               

                    
        );
    }
}


class AssignedListComponent extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            requests: [],
            orderlist: [],
            
        };
    }
 componentDidMount() {
        this.getStatus();
        //window.polling = setInterval(() => this.getStatus(), 1000);
        var that = this;
        var socket = io.connect(window.socket_url);
        console.log(`room_${window.room}_shop_${window.shop_id}`);
        socket.emit('joinShopRoom', `room_${window.room}_shop_${window.shop_id}`);
        socket.off().on('newRequest', function (data) {
            that.getStatus();
        });
    }

    componentWillUnmount() {
        // clearInterval(window.polling);
    }

    handleClick(request, e) {
        if(request.request_type == "MANUAL") {
            this.props.assignProvider(request);
        } else {
            alertMessage("Error", "Auto assigned requests cannot be assigned", "danger");
        }
        
    }

    handletakeaway(request, e) {
        e.stopPropagation();
          $.ajax({
                url: getBaseUrl() + "/shop/dispatcher/pickedup",
                type: "post",
                headers: {
                    Authorization: "Bearer " + getToken("shop")
                },
                'beforeSend': function (request) {
                    showLoader();
                },
                data: {
                    id: request.id,
                    store_id: request.store_id,
                    user_id: request.user.id,
                },
                success: (response, textStatus, jqXHR) => {
                alertMessage(textStatus, jqXHR.responseJSON.message, "success");
                setTimeout(function(){location.reload();}.bind(this),1000);
                }, error: (jqXHR, textStatus, errorThrown) => {}
            });
       
    }
    
    handleOrderlist(request, e) {
        e.stopPropagation();
        this.setState({
            orderlist: request,
            accept: {
                  ...this.state.accept,
                  store_order_id: request.id,
                  store_type:request.pickup.storetype.category
            }
        });
    }


    
    handleCourierOrderlist(request, e) {
        e.stopPropagation();
        this.setState({
            orderlist: request,
            accept: {
                  ...this.state.accept,
                  store_order_id: request.id
            }
        });
    }

    
    getStatus() {
        let url = getBaseUrl() + "/shop/dispatcher/orders?type="+this.props.status;
        if (getShopDetails().store_type_id == 6) {
            url = getBaseUrl() + "/shop/dispatcher/products?type="+this.props.status;
        }
        $.ajax({
            url: url,
            type: "get",
            processData: false,
            contentType: false,
            headers: {
                Authorization: "Bearer " + getToken("shop")
            },
            success: (response, textStatus, jqXHR) => {
                var data = parseData(response);
                this.setState({
                    requests: (data.responseData.length > 0) ? data.responseData : [],
                });
            }, error: (jqXHR, textStatus, errorThrown) => {}
        });
    }

    render() {

        let requests = this.state.requests;
        let {accept, errors } = this.state;

        if (getShopDetails().store_type_id != 6) {
            let invoice=(this.state.orderlist.length != 0)? this.state.orderlist.invoice.items : [];
            return (
                <div className="tab-contents row">
                    <div className="col-md-12 p-0 bg-body">
                        <div className="tab_sub_title">
                            <h6 className="m-0">Accepted List</h6>
                        </div>

                        <div className="tab_body fnt_weight_400">

                            {requests.map((request) =>
                                <div key={request.id} onClick={ this.handleClick.bind(this, request) } className="bg-white m-lr-20 shadow-sm">
                                    <a className="btn btn-sm btn-green float-right m-3">{request.status}</a>
                                    <div className="p-4">
                                        <p className="font_18 txt_clr_2 fnt_weight_700">{request.user.first_name} {request.user.last_name}</p>
                                        <p className="font_14"><strong>Number:</strong> {request.user.mobile}</p>
                                        <p className="font_14"><strong>Payment:</strong> {request.invoice.payment_mode}</p>
                                        <a className=" m-2 c-pointer btn btn-blue "  onClick={ this.handleOrderlist.bind(this, request) } data-toggle="modal" data-target="#order-list">Order List</a>
                                        {(request.order_type == 'TAKEAWAY')? <a className=" m-2 c-pointer btn btn-red"  onClick={ this.handletakeaway.bind(this, request) }> {request.status == 'PICKEDUP' ?  'TAKE AWAY' : 'ORDER READY' }  <i className="material-icons">check</i></a> : ""}
                                    </div>
                                </div>
                                )
                            }
                        </div>
                  </div>
                    <div id="order-list" className="modal fade" role="dialog">
                        <div className="modal-dialog modal-lg">
                            <div className="modal-content">
                                <div className="modal-header">
                                <h4 className="modal-title">Order List</h4>
                                </div>
                                <div className="modal-body">
                                <div className="form-row mb-3">
                                        <div className="form-group col-md-4">
                                            <label htmlFor="first_name">Order ID : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.store_order_invoice_id : ""}</b></span>
                                        </div>
                                        <div className="form-group col-md-4">
                                            <label htmlFor="last_name">SHOP Name : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.pickup.store_name : ""}</b></span>
                                        </div>
                                        <div className="form-group col-md-4">
                                            <label htmlFor="last_name">Customer Name : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.user.first_name : ""}</b></span>
                                        </div>
                                    </div>
                                    <div className="form-row mb-3">
                                        <div className="form-group col-md-4">
                                            <label htmlFor="first_name">Delivery Address : </label><span><b>{(this.state.orderlist.length != 0 && this.state.orderlist.delivery)? this.state.orderlist.delivery.map_address : ""}</b></span>
                                        </div>
                                        <div className="form-group col-md-4">
                                            <label htmlFor="last_name">Phone Number : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.user.mobile : ""}</b></span>
                                        </div>
                                        <div className="form-group col-md-4">
                                        {(accept && accept.store_type  == "OTHERS")? 
                                            <div>
                                            <label htmlFor="last_name" className="font-weight-bold" >Delivery Date : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.delivery_time : ""}</b></span>
                                        </div>
                                       :''}
                                        </div>
                                    </div> 
                                    <div className="form-row mb-3">
                                        <div className="form-group col-md-4">
                                            <label htmlFor="first_name">Note : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.note : ""}</b></span>
                                        </div>
                                        <div className="form-group col-md-4">
                                            <label htmlFor="last_name">Total Amount : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.currency+(this.state.orderlist.invoice.total_amount).toFixed(2) : ""}</b></span>
                                        </div>
                                        <div className="form-group col-md-4">
                                            <label htmlFor="last_name">Status : </label><span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.status : ""}</b></span>
                                        </div>
                                    </div>
                                   <table className="table">
                                    <thead>
                                        <tr>
                                            <th>Sno</th>
                                            <th>Product Name</th>
                                            <th>Note</th>
                                            <th>Price</th>
                                            <th>Unit</th>
                                            <th>Quantity</th>
                                            <th>Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    {invoice.map((item,i) =>
                                        <tr key={i}>
                                            <td>{i+1}</td>
                                            <td>{item.product.item_name}</td>
                                            <td>{item.note}</td>
                                            <td>{(this.state.orderlist.currency)? this.state.orderlist.currency : "$"} {item.item_price}</td>
                                            <td>{item.item_quantity} {item.unit}</td>
                                            <td>{item.quantity}</td>
                                            <td>{(this.state.orderlist.currency)? this.state.orderlist.currency : "$"} {item.total_item_price}</td>
                                        </tr>
                                    )}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Discount</th>
                                            <th><span>: </span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.currency+this.state.orderlist.invoice.discount : ""}</b></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Delivery Charge</th>
                                            <th><span>: </span> <b>{(this.state.orderlist.length != 0)? this.state.orderlist.currency+this.state.orderlist.invoice.delivery_amount : ""}</b></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Shop Package Charge</th>
                                            <th><span>: </span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.currency+this.state.orderlist.invoice.store_package_amount : ""}</b></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Shipping & Handling</th>
                                            <th><span>: </span> <b>{(this.state.orderlist.length != 0)? this.state.orderlist.currency+"0.00" : ""}</b></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Gst</th>
                                            <th><span>: </span> <b>{(this.state.orderlist.length != 0)? this.state.orderlist.currency+this.state.orderlist.invoice.tax_amount : ""}</b></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Total</th>
                                            <th><span>: </span> {(this.state.orderlist.length != 0)? this.state.orderlist.currency+this.state.orderlist.invoice.total_amount : ""}</th>
                                        </tr>
                                    </tfoot>


                                    </table>
                               </div>
                               <div className="modal-footer">
                                 <a className=" m-2 c-pointer btn btn-red "  data-dismiss="modal">Close</a>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            );
        }
        else{

            return (
                <div className="tab-contents row">
                    <div className="col-md-12 p-0 bg-body">
                        <div className="tab_sub_title">
                            <h6 className="m-0">Accepted List</h6>
                        </div>

                        <div className="tab_body fnt_weight_400">

                            {requests.map((request) =>
                                <div key={request.id} onClick={ this.handleClick.bind(this, request) } className="bg-white m-lr-20 shadow-sm">
                                    <a className="btn btn-sm btn-green float-right m-3">{request.status}</a>
                                    <div className="p-4">
                                        <p className="font_18 txt_clr_2 fnt_weight_700">{request.user.first_name} {request.user.last_name}</p>
                                        <p className="font_14"><strong>Number:</strong> {request.user.mobile}</p>
                                        <p className="font_14"><strong>Order type:</strong> {request.order_type}</p>
                                        <a className=" m-2 c-pointer btn btn-blue "  onClick={ this.handleCourierOrderlist.bind(this, request) } data-toggle="modal" data-target="#order-list">Order List</a>
                                    </div>
                                </div>
                                )
                            }
                        </div>
                  </div>

                    <div id="order-list" className="modal fade" role="dialog">
                        <div className="modal-dialog modal-lg">
                            <div className="modal-content">
                                <div className="modal-header">
                                    <h4 className="modal-title">Order List</h4>
                                </div>
                                <div className="modal-body">
                                    <div className="form-row mb-3">
                                        <div className="form-group col-md-3">
                                            <label htmlFor="first_name">Order ID:</label> <span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.store_order_invoice_id : ""}</b></span>
                                        </div>

                                        <div className="form-group col-md-3">
                                            <label htmlFor="first_name">Product ID:</label> <span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.productId : ""}</b></span>
                                        </div>
                                        <div className="form-group col-md-3">
                                            <label htmlFor="last_name">SHOP Name:</label> <span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.store.store_name : ""}</b></span>
                                        </div>
                                        <div className="form-group col-md-3">
                                            <label htmlFor="last_name">Customer Name:</label> <span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.user.first_name : ""}</b></span>
                                        </div>
                                    </div>
                                    <div className="form-row mb-3">
                                        <div className="form-group col-md-4">
                                            <label htmlFor="first_name">Delivery Address:</label> <span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.pickup_address : ""}</b></span>
                                        </div>
                                        <div className="form-group col-md-4">
                                            <label htmlFor="last_name">Phone Number:</label> <span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.user.mobile : ""}</b></span>
                                        </div>

                                        <div className="form-group col-md-4">
                                            <label htmlFor="first_name">Package Description:</label> <span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.package_description : ""}</b></span>
                                        </div>
                                    </div> 
                                    <div className="form-row mb-3">
                                        <div className="form-group col-md-4">
                                            <label htmlFor="first_name">Scheduled At:</label> <span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.schedule_datetime : ""}</b></span>
                                        </div>
                                        <div className="form-group col-md-4">
                                            <label htmlFor="last_name">Collectable Delivery Cost: </label> <span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.currency+ parseFloat(this.state.orderlist.collectable_delivery_cost).toFixed(2) : ""}</b></span>
                                        </div>
                                        <div className="form-group col-md-4">
                                            <label htmlFor="last_name">Status:</label> <span><b>{(this.state.orderlist.length != 0)? this.state.orderlist.status : ""}</b></span>
                                        </div>
                                    </div>
                                </div>
                                <div className="modal-footer">
                                    <a className=" m-2 c-pointer btn btn-red "  data-dismiss="modal">Close</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            );

        }
    }
}

ReactDOM.render(<MainComponent />, document.getElementById("root"));
