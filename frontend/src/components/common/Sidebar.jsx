import React, { useContext } from 'react'
import { Link } from 'react-router-dom';
import { AdminAuthContext } from '../context/AdminAuth'

const Sidebar = () => {
    const {logout} = useContext(AdminAuthContext);
    return (
        <div className='card shadow mb-5 sidebar'>
            <div className='card-body p-4'>
                <ul>
                    <li><Link to="">Dashboard</Link></li>
                    <li><Link to="">Categories</Link></li>
                    <li><Link to="">Brands</Link></li>
                    <li><Link to="">Products</Link></li>
                    <li><Link to="">Orders</Link></li>
                    <li><Link to="">Users</Link></li>
                    <li><Link to="">Shipping</Link></li>
                    <li><Link to="">Change Password</Link></li>
                    <li><a href="javascript:;" onClick={logout}>LogOut</a></li>
                </ul>
            </div>
        </div>
    )
}

export default Sidebar
