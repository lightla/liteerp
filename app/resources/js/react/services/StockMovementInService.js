import api from "../common/api";

const StockMovementInService = {
    add: (data) => api.post("/business-access/stock-movement-ins", data),
    show: (id) => api.get("/business-access/stock-movement-ins/" + id),
    list: (data) => api.get("/business-access/stock-movement-ins" 
        + `?page=${data.page}&keywords=${data.keywords}&stock_in_id=${data.stock_in_id}`),
    update: (data) => api.put("/business-access/stock-movement-ins/" + data.id, data),
};
export default StockMovementInService;