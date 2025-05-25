import React, { useEffect, useState } from 'react'
import Layout from '../../common/Layout'
import Sidebar from '../../common/Sidebar'
import { Link, useNavigate, useParams } from 'react-router-dom'
import { adminToken, apiUrl } from '../../common/http';
import { useForm } from 'react-hook-form';
import { toast } from 'react-toastify';

const Edit = () => {
  useEffect(() => {
    document.title = "Admin | Edit Brand";
  }, []);

  const [disable, setDisable] = useState(false)
  const navigate = useNavigate();

  const params = useParams();

  const {
    register,
    handleSubmit,
    watch,
    reset,
    formState: { errors },
  } = useForm({
    defaultValues: async () => {
      const res = await fetch(`${apiUrl}/brands/${params.id}`, {
        method: 'GET',
        headers: {
          'Content-type': 'application/json',
          'Accept': 'application/json',
          'Authorization': `Bearer ${adminToken()}`
        }
      })
        .then(res => res.json())
        .then(result => {
          if (result.status === 200) {
            reset({
              name: result.data.name,
              status: result.data.status,
            })
          } else {
            console.log("Something Went Wrong!");
          }
        })
    }
  });

  const saveBrand = async (data) => {
    setDisable(true);

    const res = await fetch(`${apiUrl}/brands/${params.id}`, {
      method: 'PUT',
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
          navigate('/admin/brands')
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
            <h4 className='h4 pb-0 mb-0'>Brands / Edit</h4>
            <Link to='/admin/brands' className='btn btn-primary'>Back</Link>
          </div>
          <div className='col-md-3'>
            <Sidebar />
          </div>
          <div className='col-md-9'>
            <form onSubmit={handleSubmit(saveBrand)}>
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
                    className='btn btn-primary mt-3'>Update</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </Layout>
  )
}

export default Edit
