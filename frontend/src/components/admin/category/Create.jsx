import React, { useEffect, useState } from 'react'
import Layout from '../../common/Layout'
import Sidebar from '../../common/Sidebar'
import { Link, useNavigate } from 'react-router-dom'
import { useForm } from 'react-hook-form'
import { toast } from 'react-toastify'
import { adminToken, apiUrl } from '../../common/http'

const Create = () => {
    useEffect(() => {
        document.title = "Admin | Create Category";
    }, []);

    const [disable, setDisable] = useState(false)
    const navigate = useNavigate();

    const {
        register,
        handleSubmit,
        watch,
        formState: { errors },
    } = useForm();

    const saveCategory = async (data) => {
        setDisable(true);
        console.log(data);

        const res = await fetch(`${apiUrl}/categories`, {
            method: 'POST',
            headers: {
                'Content-type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${adminToken()}`
            },
            body: JSON.stringify(data)
        }).then(res => res.json())
            .then(result => {
                setDisable(false);
                if (result.status === 200) {
                    toast.success(result.message);
                    navigate('/admin/categories')
                } else if (result.status === 400) {
                    const apiError = result.errors?.name?.[0] || "An unexpected error occurred.";
                    toast.error(apiError);
                }
                else {
                    console.log("Something Went Wrong!");
                }
            })
    }

    return (
        <Layout>
            <div className='container'>
                <div className='row'>
                    <div className='d-flex justify-content-between mt-5 pb-3'>
                        <h4 className='h4 pb-0 mb-0'>Categories / Create</h4>
                        <Link to='/admin/categories' className='btn btn-primary'>Back</Link>
                    </div>
                    <div className='col-md-3'>
                        <Sidebar />
                    </div>
                    <div className='col-md-9'>
                        <form onSubmit={handleSubmit(saveCategory)}>
                            <div className='card shadow'>
                                <div className='card-body p-4'>
                                    <div className='mb-3'>
                                        <label className='form-label'>Name</label>
                                        <input type="text"
                                            {
                                            ...register('name', {
                                                required: 'The name filed is required.'
                                            })
                                            }
                                            className={`form-control ${errors.name && 'is-invalid'}`}
                                            placeholder='Name' />
                                        {
                                            errors.name && <p className='invalid-feedback'>{errors.name?.message}</p>
                                        }
                                    </div>
                                    <div className='mb-3'>
                                        <label className='form-label'>Status</label>
                                        <select
                                            {
                                            ...register('status', {
                                                required: 'Please Select a Status.'
                                            })
                                            }
                                            className={`form-control ${errors.name && 'is-invalid'}`}
                                        >
                                            <option value="">Select a Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
                                        </select>
                                        {
                                            errors.status && <p className='invalid-feedback'>{errors.status?.message}</p>
                                        }
                                    </div>
                                    <button
                                        disabled={disable}
                                        className='btn btn-primary mt-3'>Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </Layout>
    )
}

export default Create
