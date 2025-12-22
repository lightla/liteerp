import api from "../common/api";

 const ProductService = {
  add: (data) => api.post("/business-access/products",data),
  show: (id) => api.get("/business-access/products/" + id),
  list: ({
    keywords = '',
    page = 0,
    order_by = ''
  }) => api.get("/business-access/products" 
    + `?keywords=${keywords}&page=${page}&order_by=${order_by}`),
  listByPurchaseId: (data) => api.get("/business-access/products" + 
    `?purchase_id=${data.purchase_id}&keywords=${data.keywords}&page=${data.page}&active=${data.active}`),
  addCategory: (data) => api.post("/business-access/category-product",data),
  updateCategory: (data) => api.put("/business-access/category-product/" + data.id,data),
  listCategory: ({
    keywords = '',
    page = 0
  }) => api.get("/business-access/category-product?keywords=" 
      + `${keywords}&page=${page}`),
  update: (data) => api.put("/business-access/products/" + data.id,data),
  delete: (data) => api.delete("/business-access/products/" + data.id),
  deleteCategory: (data) => api.delete("/business-access/category-product/" + data.id),
};
export default ProductService;