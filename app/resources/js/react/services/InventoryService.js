import api from "../common/api";

const InventoryService = {
    add: (data) => api.post("/business-access/inventory", data),
    show: (id) => api.get("/business-access/inventory/" + id),
    list: ({
        page = 0,
        keywords = '',
        customer_group_id = '',
    }) => api.get("/business-access/inventory"
         + `?page=${page}&keywords=${keywords}${customer_group_id 
                ? '&customer_group_id=' + customer_group_id : ''}`),
    update: (data) => api.put("/business-access/inventory/" + data.id, data),
};
export default InventoryService;