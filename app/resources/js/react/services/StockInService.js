import api from "../common/api";

 const StockInService = {
  add: (data) => api.post("/business-access/stocks/ins",data),
  show: (id) => api.get("/business-access/stocks/ins/" + id),
  list: (data) => api.get("/business-access/stocks/ins"
    + `?page=${data.page}&keywords=${data.keywords}
      &status=${data.status}&order_by=${data.order_by}`),
  update: (data) => api.put("/business-access/stocks/ins/" + data.id,data),
};
export default StockInService;