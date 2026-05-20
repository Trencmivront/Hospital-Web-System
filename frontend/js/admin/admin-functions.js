export const showError = async (response) => {
    console.log(response);
    const message = await response.json();
}

export const userIsNotAuthenticated = () => {
    alert("Please Go Away");
    window.location = "/";
}

const fetchData = async (api) =>{
    try{
        const response = await fetch(api);

        if(response.status === 403){
            userIsNotAuthenticated();
            return;
        }

        else if (!response.ok){
            showError(response);
            return [];
        }

        return await response.json();      
        }catch(error){
        console.error("Fetch error:", error);
        return [];
    }
}

// 
export const logout = () => {
    return fetchData("/api/admin/logout");
}

export const getTodaysAppointments = () => {
    return fetchData("/api/appointment/getToday");
}

export const getAppointments = () => {
    return fetchData("/api/appointment/all");
}

export const getPatients = () => {
    return fetchData("/api/patient/all");
}

export const getDoctors = () => {
    return fetchData("/api/doctor/all");
}

export const getMonthlyRevenue = () => {
    return fetchData("/api/bill/monthlyRevenue");
}