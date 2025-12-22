import api from "../common/api";

 const PriceListService = {
  add: (data) => api.post("/business-access/price-lists",data),
  show: (id) => api.get("/business-access/price-lists/" + id),
  list: ({
    keywords = '',
    page = 0
  }) => api.get("/business-access/price-lists" 
      + `?keywords=${keywords}&page=${page}`),
  update: (data) => api.put("/business-access/price-lists/" + data.id,data),
  delete: (data) => api.delete("/business-access/price-lists/" + data.id),
};
export default PriceListService;